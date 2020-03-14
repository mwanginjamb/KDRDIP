<?php

namespace backend\controllers;

use Yii;
use app\models\Complaints;
use app\models\ComplaintTypes;
use app\models\ComplaintTiers;
use app\models\ComplaintChannels;
use app\models\ComplaintPriorities;
use app\models\ComplaintStatus;
use app\models\Countries;
use app\models\Counties;
use app\models\Projects;
use app\models\SubCounties;
use app\models\Wards;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * ComplaintsController implements the CRUD actions for Complaints model.
 */
class ComplaintsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(80);

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
	 * Lists all Complaints models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Complaints::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Complaints model.
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
	 * Creates a new Complaints model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Complaints();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ComplaintID]);
		}

		$countries = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');
		$complaintTypes = ArrayHelper::map(ComplaintTypes::find()->all(), 'ComplaintTypeID', 'ComplaintTypeName');
		$complaintTiers = ArrayHelper::map(ComplaintTiers::find()->all(), 'ComplaintTierID', 'ComplaintTierName');
		$complaintChannels = ArrayHelper::map(ComplaintChannels::find()->all(), 'ComplaintChannelID', 'ComplaintChannelName');
		$complaintPriorities = ArrayHelper::map(ComplaintPriorities::find()->all(), 'ComplaintPriorityID', 'ComplaintPriorityName');
		$complaintStatus = ArrayHelper::map(ComplaintStatus::find()->all(), 'ComplaintStatusID', 'ComplaintStatusName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$subCounties = ArrayHelper::map(SubCounties::find()->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->all(), 'WardID', 'WardName');
		$users = ArrayHelper::map(Users::find()->all(), 'UserID', 'FullName');

		return $this->render('create', [
			'model' => $model,
			'rights' => $this->rights,
			'countries' => $countries,
			'complaintTypes' => $complaintTypes,
			'complaintTiers' => $complaintTiers,
			'complaintChannels' => $complaintChannels,
			'complaintPriorities' => $complaintPriorities,
			'complaintStatus' => $complaintStatus,
			'counties' => $counties,
			'projects' => $projects,
			'subCounties' => $subCounties,
			'wards' => $wards,
			'users' => $users,
		]);
	}

	/**
	 * Updates an existing Complaints model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ComplaintID]);
		}

		$countries = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');
		$complaintTypes = ArrayHelper::map(ComplaintTypes::find()->all(), 'ComplaintTypeID', 'ComplaintTypeName');
		$complaintTiers = ArrayHelper::map(ComplaintTiers::find()->all(), 'ComplaintTierID', 'ComplaintTierName');
		$complaintChannels = ArrayHelper::map(ComplaintChannels::find()->all(), 'ComplaintChannelID', 'ComplaintChannelName');
		$complaintPriorities = ArrayHelper::map(ComplaintPriorities::find()->all(), 'ComplaintPriorityID', 'ComplaintPriorityName');
		$complaintStatus = ArrayHelper::map(ComplaintStatus::find()->all(), 'ComplaintStatusID', 'ComplaintStatusName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$subCounties = ArrayHelper::map(SubCounties::find()->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->all(), 'WardID', 'WardName');
		$users = ArrayHelper::map(Users::find()->all(), 'UserID', 'FullName');

		return $this->render('update', [
			'model' => $model,
			'rights' => $this->rights,
			'countries' => $countries,
			'complaintTypes' => $complaintTypes,
			'complaintTiers' => $complaintTiers,
			'complaintChannels' => $complaintChannels,
			'complaintPriorities' => $complaintPriorities,
			'complaintStatus' => $complaintStatus,
			'counties' => $counties,
			'projects' => $projects,
			'subCounties' => $subCounties,
			'wards' => $wards,
			'users' => $users,
		]);
	}

	/**
	 * Deletes an existing Complaints model.
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
	 * Finds the Complaints model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Complaints the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Complaints::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
