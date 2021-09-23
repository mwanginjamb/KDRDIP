<?php

namespace backend\controllers;

use Yii;
use app\models\Tasks;
use app\models\TaskNotes;
use app\models\TaskStatus;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use backend\controllers\UsersController;

/**
 * RequisitionController implements the CRUD actions for Quotation model.
 */
class TasksAssignedController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(125);

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
	 * Lists all ProcurementPlan models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Tasks::find()->joinWith('users')->andWhere(['assignedTo'=> Yii::$app->user->identity->UserID]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Quotation model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{	
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		$params = Yii::$app->request->post();

		$approvalNotesProvider = new ActiveDataProvider([
			'query' => TaskNotes::find()->where(['TaskID'=> $id]),
		]);
		
		$model = $this->findModel($id);
		
		$notes = new TaskNotes();
		
		// if (Yii::$app->request->post())
		// {
		// 	if ($params['option']==1 && isset($params['Approve']))
		// 	{
		// 		$model->ApprovalStatusID = 2;
		// 	} else if ($params['option']==2 && isset($params['Approve']))
		// 	{
		// 		$model->ApprovalStatusID = 3;

		// 		//$model->PostingDate = date('Y-m-d h:i:s');
		// 		//$model->Posted = 1;
		// 		$model->ApprovedBy  = $UserID;
		// 		$model->ApprovalDate = date('Y-m-d h:i:s');
		// 	}
			
		// 	if (isset($params['Reject']))
		// 	{
		// 		$model->ApprovalStatusID = 4;
		// 	}
		// }
		
		if (Yii::$app->request->post() && $model->save()) {			
			$params = Yii::$app->request->post();
			$notes->Notes = $params['TaskNotes']['Notes'];
			$notes->TaskStatusID = 1;
			$notes->TaskID = $id;
			$notes->CreatedBy = $UserID;
			
			$notes->save();	
			
			return $this->redirect(['index']);
		}
		
		$taskStatus = ArrayHelper::map(TaskStatus::find()->all(), 'TaskStatusID', 'TaskStatusName');
		$detailmodel = Tasks::find()->where(['TaskID'=> $id])->one();

		return $this->render('view', [
			'model' => $model,
			'notes' => $notes,
			'approvalNotesProvider' => $approvalNotesProvider,
			'rights' => $this->rights,
			'taskStatus' => $taskStatus,
			'detailmodel' => $detailmodel,
		]);
	}

	/**
	 * Deletes an existing Quotation model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Quotation model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Quotation the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Tasks::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
