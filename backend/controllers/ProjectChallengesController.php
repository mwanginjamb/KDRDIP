<?php

namespace backend\controllers;

use Yii;
use app\models\ProjectChallenges;
use app\models\ChallengeTypes;
use app\models\Employees;
use app\models\ProjectChallengeStatus;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use backend\controllers\EmployeesController;

include_once 'includes/mailsender.php';

/**
 * ProjectChallengesController implements the CRUD actions for ProjectChallenges model.
 */
class ProjectChallengesController extends Controller
{
	// public const MAIN_URL = '';
	public $rights;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(36);

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
	 * Lists all ProjectChallenges models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$pId = isset(Yii::$app->request->get()['pId']) ? Yii::$app->request->get()['pId'] : 0;
		$typeId = isset(Yii::$app->request->get()['typeId']) ? Yii::$app->request->get()['typeId'] : 0;

		/*
			Data provider for the project's major challenge. The major challenge can only be one
		*/
		$majorChallenge = new ActiveDataProvider([
			'query' => ProjectChallenges::find()->andWhere(['ProjectID' => $pId, 'MajorChallenge' => 1]),
		]);

		/*
			Data provider for the project's other challenges. Other challenges can be many
		*/
		$query = ProjectChallenges::find()->andWhere(['ProjectID' => $pId, 'MajorChallenge' => 0]);
		if ($typeId != 0) {
			$query->andWhere(['ChallengeTypeID' => $typeId]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'majorChallenge' => $majorChallenge,
			'rights' => $this->rights,
			'pId' => $pId,
			'typeId' => $typeId,
		]);
	}

	/**
	 * Displays a single ProjectChallenges model.
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
	 * Creates a new ProjectChallenges model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$pId = isset(Yii::$app->request->get()['pId']) ? Yii::$app->request->get()['pId'] : 0;
		$majorChallenge = isset(Yii::$app->request->get()['major']) ? Yii::$app->request->get()['major'] : 0;
		$typeId = isset(Yii::$app->request->get()['typeId']) ? Yii::$app->request->get()['typeId'] : 0;

		$model = new ProjectChallenges();
		$model->ProjectID = $pId;
		$model->MajorChallenge = $majorChallenge;
		$model->ChallengeTypeID = $typeId;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$x = EmployeesController::sendEmailNotification('002', $model->AssignedTo);
			return $this->redirect(['index', 'pId' => $model->ProjectID]);
		}

		$employees = ArrayHelper::map(Employees::find()->all(), 'EmployeeID', 'EmployeeName');
		$challengeTypes = ArrayHelper::map(ChallengeTypes::find()->all(), 'ChallengeTypeID', 'ChallengeTypeName');
		
		$projectChallengeStatus = ArrayHelper::map(ProjectChallengeStatus::find()->all(), 'ProjectChallengeStatusID', 'ProjectChallengeStatusName');

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'pId' => $pId,
			'employees' => $employees,
			'challengeTypes' => $challengeTypes,
			'projectChallengeStatus' => $projectChallengeStatus,
		]);
	}

	/**
	 * Updates an existing ProjectChallenges model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'pId' => $model->ProjectID]);
		}

		$employees = ArrayHelper::map(Employees::find()->all(), 'EmployeeID', 'EmployeeName');
		$challengeTypes = ArrayHelper::map(ChallengeTypes::find()->all(), 'ChallengeTypeID', 'ChallengeTypeName');
		$projectChallengeStatus = ArrayHelper::map(ProjectChallengeStatus::find()->all(), 'ProjectChallengeStatusID', 'ProjectChallengeStatusName');

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
			'pId' => $model->ProjectID,
			'employees' => $employees,
			'challengeTypes' => $challengeTypes,
			'projectChallengeStatus' => $projectChallengeStatus,
		]);
	}

	/**
	 * Deletes an existing ProjectChallenges model.
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
	 * Finds the ProjectChallenges model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return ProjectChallenges the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ProjectChallenges::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
