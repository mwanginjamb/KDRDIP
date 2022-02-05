<?php

namespace backend\controllers;

use Yii;
use app\models\LipwHouseholds;
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
 * LipwHouseholdsController implements the CRUD actions for LipwHouseholds model.
 */
class LipwHouseholdsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		// $this->rights = RightsController::Permissions(97);
		
		
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
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
	 * Lists all LipwHouseholds models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => LipwHouseholds::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single LipwHouseholds model.
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
	 * Creates a new LipwHouseholds model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new LipwHouseholds();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->HouseholdID]);
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
	 * Updates an existing LipwHouseholds model.
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
			return $this->redirect(['view', 'id' => $model->HouseholdID]);
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
	 * Deletes an existing LipwHouseholds model.
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
	 * Finds the LipwHouseholds model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwHouseholds the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwHouseholds::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
