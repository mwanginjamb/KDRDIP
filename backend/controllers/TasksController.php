<?php

namespace backend\controllers;

use Yii;
use app\models\Tasks;
use app\models\TaskMilestones;
use app\models\TaskStatus;
use app\models\TaskNotes;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\web\UploadedFile;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
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
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Tasks models.
	 * @return mixed
	 */
	public function actionIndex($pId)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Tasks::find()->andWhere(['ProjectID' => $pId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'pId' => $pId,
		]);
	}

	/**
	 * Displays a single Tasks model.
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
	 * Creates a new Tasks model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($pId)
	{
		$model = new Tasks();
		$model->ProjectID = $pId;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->TaskID]);
		}

		$taskStatus = ArrayHelper::map(TaskStatus::find()->all(), 'TaskStatusID', 'TaskStatusName');
		$taskMilestones = ArrayHelper::map(TaskMilestones::find()->all(), 'TaskMilestoneID', 'TaskMilestoneName');
		$users = ArrayHelper::map(Users::find()->all(), 'UserID', 'FullName');

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'taskStatus' => $taskStatus,
			'taskMilestones' => $taskMilestones,
			'users' => $users,
		]);
	}

	/**
	 * Updates an existing Tasks model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->TaskID]);
		}

		$taskStatus = ArrayHelper::map(TaskStatus::find()->all(), 'TaskStatusID', 'TaskStatusName');
		$taskMilestones = ArrayHelper::map(TaskMilestones::find()->all(), 'TaskMilestoneID', 'TaskMilestoneName');
		$users = ArrayHelper::map(Users::find()->all(), 'UserID', 'FullName');

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
			'taskStatus' => $taskStatus,
			'taskMilestones' => $taskMilestones,
			'users' => $users,
		]);
	}

	/**
	 * Deletes an existing Tasks model.
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
	 * Finds the Tasks model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Tasks the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Tasks::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
