<?php

namespace backend\controllers;

use Yii;
use app\models\YouthPlacement;
use app\models\Countries;
use app\models\Counties;
use app\models\SubCounties;
use app\models\Wards;
use app\models\SubLocations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * YouthPlacementController implements the CRUD actions for YouthPlacement model.
 */
class YouthPlacementController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(92);

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
	 * Lists all YouthPlacement models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => YouthPlacement::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single YouthPlacement model.
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
	 * Creates a new YouthPlacement model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new YouthPlacement();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->YouthPlacementID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'WardID', 'WardName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID])->all(), 'SubLocationID', 'SubLocationName');
		$countries = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'wards' => $wards,
			'countries' => $countries,
			'subLocations' => $subLocations,
		]);
	}

	/**
	 * Updates an existing YouthPlacement model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->YouthPlacementID]);
		}

		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID])->all(), 'WardID', 'WardName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID])->all(), 'SubLocationID', 'SubLocationName');
		$countries = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'wards' => $wards,
			'countries' => $countries,
			'subLocations' => $subLocations,
		]);
	}

	/**
	 * Deletes an existing YouthPlacement model.
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
	 * Finds the YouthPlacement model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return YouthPlacement the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = YouthPlacement::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
