<?php

namespace backend\controllers;

use Yii;
use app\models\SubLocations;
use app\models\SubCounties;
use app\models\Counties;
use app\models\Locations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * SubLocationsController implements the CRUD actions for SubLocations model.
 */
class SubLocationsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(79);

		$rightsArray = []; 
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update', 'approval', 'approvallist', 'submit');
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
			'only' => ['index', 'view', 'create', 'update', 'delete', 'approval', 'approvallist', 'submit'],
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
	 * Lists all SubLocations models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => SubLocations::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single SubLocations model.
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
	 * Creates a new SubLocations model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new SubLocations();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = [];

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->SubLocationID]);
		}

		return $this->render('create', [
			'model' => $model,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing SubLocations model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->CountyID = $model->locations->subCounties->CountyID;
		$model->SubCountyID = $model->locations->SubCountyID;

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->where(['LocationID' => $model->SubCountyID ])->all(), 'LocationID', 'LocationName');

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->SubLocationID]);
		}

		return $this->render('update', [
			'model' => $model,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing SubLocations model.
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
	 * Finds the SubLocations model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return SubLocations the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = SubLocations::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionSubCounties($id)
	{
		$model = SubCounties::find()->where(['CountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option>Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->SubCountyID . "'>" . $item->SubCountyName . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}

	public function actionLocations($id)
	{
		$model = Locations::find()->where(['SubCountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option>Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->LocationID . "'>" . $item->LocationName . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}
}
