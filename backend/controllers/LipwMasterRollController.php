<?php

namespace backend\controllers;

use Yii;
use app\models\LipwMasterRoll;
use app\models\LipwBeneficiaries;
use app\models\LipwMasterRollRegister;
use app\models\Counties;
use app\models\SubCounties;
use app\models\Locations;
use app\models\SubLocations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * LipwMasterRollController implements the CRUD actions for LipwMasterRoll model.
 */
class LipwMasterRollController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(99);

		$rightsArray = [];
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update');
		}
		if (isset($this->rights->Delete)) {
			array_push($rightsArray, 'delete');
		}
		$rightsArray = array_unique($rightsArray);
		
		if (count($rightsArray) <= 0) {
			$rightsArray = ['none'];
		}
		
		return [
		'access' => [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete'],
			'rules' => [
					// Guest Users
					[
						'allow' => true,
						'actions' => ['none'],
						'roles' => ['?'],
					],
					// Authenticated Users
					[
						'allow' => true,
						'actions' => $rightsArray, //['index', 'view', 'create', 'update', 'delete'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all LipwMasterRoll models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => LipwMasterRoll::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single LipwMasterRoll model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new LipwMasterRoll model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new LipwMasterRoll();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			/* Add existing beneficiaries to the new master-roll register*/
			$beneficiaries = LipwBeneficiaries::find()->joinWith('lipwHouseHolds')
																	->andWhere(['lipw_households.SubLocationID' => $model->SubLocationID])
																	->all();
			foreach ($beneficiaries as $beneficiary) {
				$m = new LipwMasterRollRegister();
				$m->BeneficiaryID = $beneficiary->BeneficiaryID;
				$m->MasterRollID = $model->MasterRollID;
				$m->DateAdded = date('Y-m-d');
				$m->Rate = 250;
				$m->Active = 1;
				$m->save();
			}
			return $this->redirect(['view', 'id' => $model->MasterRollID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$subLocations = [];

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	/**
	 * Updates an existing LipwMasterRoll model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$subLocation = SubLocations::find()->joinWith('locations')
				->joinWith('locations.subCounties')
				->joinWith('locations.subCounties.counties')
				->where($model->SubLocationID)->one();
		$model->CountyID = $subLocation->locations->subCounties->CountyID;
		$model->SubCountyID = $subLocation->locations->SubCountyID;
		$model->LocationID = $subLocation->locations->LocationID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->MasterRollID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->where(['LocationID' => $model->SubCountyID ])->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->LocationID ])->all(), 'SubLocationID', 'SubLocationName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	/**
	 * Deletes an existing LipwMasterRoll model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the LipwMasterRoll model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwMasterRoll the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwMasterRoll::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
