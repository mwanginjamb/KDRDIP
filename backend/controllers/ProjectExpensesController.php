<?php

namespace backend\controllers;

use Yii;
use app\models\ProjectExpenses;
use app\models\ExpenseTypes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * ProjectExpensesController implements the CRUD actions for ProjectExpenses model.
 */
class ProjectExpensesController extends Controller
{
	public $rights;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(122);

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
					'delete' => ['POST', 'GET'],
				],
			],
		];
	}

	/**
	 * Lists all ProjectExpenses models.
	 * @return mixed
	 */
	public function actionIndex($pId)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => ProjectExpenses::find()->andWhere(['ProjectID' => $pId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
		]);
	}

	/**
	 * Displays a single ProjectExpenses model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->renderPartial('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new ProjectExpenses model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($pId)
	{
		$model = new ProjectExpenses();
		$model->ProjectID = $pId;
		$model->Date = date('Y-m-d');
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProjectExpenseID]);
		}

		$expenseTypes = ArrayHelper::map(ExpenseTypes::find()->all(), 'ExpenseTypeID', 'ExpenseTypeName');

		return $this->renderPartial('create', [
			'model' => $model,
			'expenseTypes' => $expenseTypes,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing ProjectExpenses model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->ProjectExpenseID]);
		}

		$expenseTypes = ArrayHelper::map(ExpenseTypes::find()->all(), 'ExpenseTypeID', 'ExpenseTypeName');
		return $this->renderPartial('update', [
			'model' => $model,
			'expenseTypes' => $expenseTypes,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing ProjectExpenses model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$this->findModel($id)->delete();

		return $this->redirect(['index', 'pId' => $model->ProjectID]);
	}

	/**
	 * Finds the ProjectExpenses model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ProjectExpenses the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ProjectExpenses::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
