<?php

namespace backend\controllers;

use Yii;
use app\models\Documents;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
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
class DocumentApprovalsController extends Controller
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
	public function actionIndex($option)
	{
		$StatusID = $option == 1 ? 1 : 2;
		$dataProvider = new ActiveDataProvider([
			'query' => Documents::find()->joinWith('users')->andWhere(['ApprovalStatusID'=>$StatusID])->andWhere(['DocumentCategoryID' => 6]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'option' => $option,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Quotation model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id, $option)
	{	
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		$params = Yii::$app->request->post();

		$approvalNotesProvider = new ActiveDataProvider([
			'query' => ApprovalNotes::find()->where(['ApprovalID'=> $id, 'ApprovalTypeID' => 11]),
		]);
		
		$model = $this->findModel($id);
		
		$notes = new ApprovalNotes();
		
		if (Yii::$app->request->post())
		{
			if ($params['option']==1 && isset($params['Approve']))
			{
				$model->ApprovalStatusID = 2;
			} else if ($params['option']==2 && isset($params['Approve']))
			{
				$model->ApprovalStatusID = 3;

				//$model->PostingDate = date('Y-m-d h:i:s');
				//$model->Posted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');
			}
			
			if (isset($params['Reject']))
			{
				$model->ApprovalStatusID = 4;
			}
		}
		
		if (Yii::$app->request->post() && $model->save()) {			
			$params = Yii::$app->request->post();
			$option = $params['option'];
			//print_r($params); exit;
			$notes->Note = $params['ApprovalNotes']['Note'];
			$notes->ApprovalStatusID = $model->ApprovalStatusID;
			$notes->ApprovalTypeID = 11;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			
			$notes->save();	
			
			if ($model->ApprovalStatusID == 2)
			{
				$result = UsersController::sendEmailNotification(26); 
			}
			return $this->redirect(['index', 'option'=> $option]);
		} else {
			//print_r($model->getErrors()); exit;
			$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where("ApprovalStatusID > 1")->all(), 'ApprovalStatusID', 'ApprovalStatusName');
			$detailmodel = Documents::find()->where(['DocumentID'=> $id])->joinWith('approvalstatus')->one();
			return $this->render('view', [
				'model' => $model,'detailmodel' => $detailmodel, 
				'approvalstatus' => $approvalstatus, 
				'notes' => $notes, 'option' => $option,
				'approvalNotesProvider' => $approvalNotesProvider,
				'rights' => $this->rights,
			]);
		}
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
		if (($model = Documents::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
