<?php

namespace backend\controllers;

use Yii;
use app\models\Employees;
use app\models\Search;
use app\models\Departments;
use app\models\Countries;
use app\models\MessageTemplates;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(20);

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
	 * Lists all Employees models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchfor = [1 => 'ID', 2 => 'Employee Name', 3 => 'Mobile', 4 => 'Email'];
		$search = new Search();
		$params = Yii::$app->request->post();
		$where = '';
		if (!empty($params)) {
			if ($params['Search']['searchfor'] == 1) {
				$searchstring = $params['Search']['searchstring'];
				$where = "SupplierID = '$searchstring'";
			} elseif ($params['Search']['searchfor'] == 2) {
				$searchstring = $params['Search']['searchstring'];
				$where = "FirstName like '%$searchstring%' || MiddleName like '%$searchstring%' || LastName like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 3) {
				$searchstring = $params['Search']['searchstring'];
				$where = "Mobile like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 4) {
				$searchstring = $params['Search']['searchstring'];
				$where = "Email like '%$searchstring%'";
			}
			$search->searchfor = $params['Search']['searchfor'];
			$search->searchstring = $params['Search']['searchstring'];
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Employees::find()->where($where),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'search' => $search,
			'searchfor' => $searchfor,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Employees model.
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
	 * Creates a new Employees model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Employees();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->EmployeeID]);
		}

		$countries = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');
		$departments = ArrayHelper::map(Departments::find()->all(), 'DepartmentID', 'DepartmentName');

		return $this->render('create', [
			'model' => $model,
			'countries' => $countries,
			'departments' => $departments,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Employees model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->EmployeeID]);
		}
		
		$countries = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');
		$departments = ArrayHelper::map(Departments::find()->all(), 'DepartmentID', 'DepartmentName');

		return $this->render('update', [
			'model' => $model,
			'countries' => $countries,
			'departments' => $departments,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Employees model.
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
	 * Finds the Employees model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Employees the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Employees::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public static function sendEmailNotification($code, $employeeId)
	{

		$template = MessageTemplates::findone(['Code' => $code]);
		if (!$template) {
			return 'template not found';
		}
		
		$user = Employees::findOne($employeeId);
		if (!$user) {
			return 'User not found';
		}

		$EmailArray = [];
		if ($user) {
			$EmailArray[] = ['Email' => $user['Email'], 'Name'=> $user['FirstName'] . ' ' . $user['LastName']];
		}

		if (!empty($template)) {
			$subject = $template->Subject;
			$message = $template->Message;
		}
		// print_r($EmailArray); exit;
		if (count($EmailArray)!=0) {
			$sent = SendMail($EmailArray, $subject, $message, null);
			if ($sent==1) {
				Yii::$app->session->setFlash('success', 'Saved Details Successfully');
				return 'Saved Details Successfully';
			} else {
				Yii::$app->session->setFlash('error', 'Failed to send Mail');
				return 'Failed to send Mail';
			}
		} else {
			Yii::$app->session->setFlash('error', 'Failed to send Mail - No Email address');
			return 'No Email address';
		}
	}
}
