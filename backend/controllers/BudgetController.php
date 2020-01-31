<?php

namespace backend\controllers;

use Yii;
use app\models\Budget;
use app\models\BudgetLines;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * BudgetController implements the CRUD actions for Budget model.
 */
class BudgetController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(9);

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
	 * Lists all Budget models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Budget::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Budget model.
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
	 * Creates a new Budget model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Budget();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->ProjectID = Yii::$app->request->get()['pid'];

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$columns = $params['BudgetLines'];
			
			foreach ($columns as $key => $column) {
				if ($column['BudgetLineID'] == '') {
					if (trim($column['Amount']) != '') {
						$_column = new BudgetLines();
						$_column->BudgetID = $model->BudgetID;
						$_column->AccountID = $column['AccountID'];
						$_column->ProjectID = Yii::$app->request->get()['pid'];
						$_column->CreatedBy = Yii::$app->user->identity->UserID;
						$_column->save();
					}
				} else {
					$_column = BudgetLines::findOne($column['BudgetLineID']);
					$_column->Amount = $column['Amount'];
					$_column->save();
				}
			}
			return $this->redirect(['/projects/view', 'id' => $model->ProjectID]);
		}
		$budgetID = 0;

		$sql = "select temp.*, accounts.AccountID, accounts.AccountName, accounts.AccountCode FROM (
					Select * FROM budgetlines 
					WHERE budgetlines.BudgetID = $budgetID
					) temp
					RIGHT JOIN accounts ON accounts.AccountID = temp.AccountID";

		$lines = BudgetLines::findBySql($sql)->asArray()->all();

		$budgetLines = [];
		foreach ($lines as $key => $line) {
			$budgetLines[$key] = new BudgetLines();
			$budgetLines[$key]->BudgetLineID = $line['BudgetLineID'];
			$budgetLines[$key]->BudgetID		= $line['BudgetID'];
			$budgetLines[$key]->AccountID		= $line['AccountID'];
			$budgetLines[$key]->Amount			= $line['Amount'];
			$budgetLines[$key]->AccountName	= $line['AccountName'];
			$budgetLines[$key]->AccountCode	= $line['AccountCode'];
		}

		return $this->render('create', [
			'model' => $model,
			'budgetLines' => $budgetLines,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Budget model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->ProjectID = Yii::$app->request->get()['pid'];

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$columns = $params['BudgetLines'];
			// print '<pre>';
			// print_r(Yii::$app->request->get()['pid']); exit;
			
			foreach ($columns as $key => $column) {
				if ($column['BudgetLineID'] == '') {
					if (trim($column['Amount']) != '') {
						$_column = new BudgetLines();
						$_column->BudgetID = $model->BudgetID;
						$_column->AccountID = $column['AccountID'];
						$_column->CreatedBy = Yii::$app->user->identity->UserID;
						$_column->save();
					}
				} else {
					$_column = BudgetLines::findOne($column['BudgetLineID']);
					$_column->Amount = $column['Amount'];
					$_column->save();
				}
			}
			return $this->redirect(['/projects/view', 'id' => $model->ProjectID]);
		}

		$budgetID = $model->BudgetID;

		$sql = "select temp.*, accounts.AccountID, accounts.AccountName, accounts.AccountCode  FROM (
					Select * FROM budgetlines 
					WHERE budgetlines.BudgetID = $budgetID
					) temp
					RIGHT JOIN accounts ON accounts.AccountID = temp.AccountID";
					
		$lines = BudgetLines::findBySql($sql)->asArray()->all();
		$budgetLines = [];
		foreach ($lines as $key => $line) {
			$budgetLines[$key] = new BudgetLines();
			$budgetLines[$key]->BudgetLineID = $line['BudgetLineID'];
			$budgetLines[$key]->BudgetID		= $line['BudgetID'];
			$budgetLines[$key]->AccountID		= $line['AccountID'];
			$budgetLines[$key]->Amount			= $line['Amount'];
			$budgetLines[$key]->AccountName	= $line['AccountName'];
			$budgetLines[$key]->AccountCode	= $line['AccountCode'];
		}

		return $this->render('update', [
			'model' => $model,
			'budgetLines' => $budgetLines,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing Budget model.
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
	 * Finds the Budget model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Budget the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Budget::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
