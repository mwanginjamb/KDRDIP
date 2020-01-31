<?php

namespace backend\controllers;

use Yii;
use app\models\Employees;
use app\models\Search;
use app\models\Departments;
use app\models\Countries;
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
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
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
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
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
}
