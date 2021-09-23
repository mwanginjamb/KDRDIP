<?php

namespace backend\controllers;

use Yii;
use app\models\ProcurementPlan;
use app\models\QuotationProducts;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\ProcurementPlanLines;
use app\models\Product;
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
class ProcurementLineApprovalsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(126);

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
		$StatusID = $option==1 ? 1 : 2;
		$dataProvider = new ActiveDataProvider([
			'query' => ProcurementPlanLines::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'option' => $option,
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
			'query' => ApprovalNotes::find()->where(['ApprovalID'=> $id, 'ApprovalTypeID' => 9]),
		]);
		
		$model = $this->findModel($id);
		
		$notes = new ApprovalNotes();
		
		if (Yii::$app->request->post()) {
			if ($params['option']==1 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 2;
			} else if ($params['option'] == 2 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 3;

				//$model->PostingDate = date('Y-m-d h:i:s');
				$model->Deleted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');
			}
			
			if (isset($params['Reject'])) {
				$model->ApprovalStatusID = 4;
			}
		}
		
		if (Yii::$app->request->post() && $model->save()) {			
			$params = Yii::$app->request->post();
			$option = $params['option'];

			$notes->Note = $params['ApprovalNotes']['Note'];
			$notes->ApprovalStatusID = $model->ApprovalStatusID;
			$notes->ApprovalTypeID = 9;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			
			$notes->save();	
			
			if ($model->ApprovalStatusID == 2) {
				// $result = UsersController::sendEmailNotification(26); 
			}
			return $this->redirect(['index', 'option'=> $option]);
		}

		$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where("ApprovalStatusID > 1")->all(), 'ApprovalStatusID', 'ApprovalStatusName');
		$detailmodel = ProcurementPlanLines::find()->where(['ProcurementPlanLineID'=> $id])->joinWith('approvalstatus')->one();
		return $this->render('view', [
			'model' => $model,'detailmodel' => $detailmodel, 
			'approvalstatus' => $approvalstatus, 
			'notes' => $notes, 'option' => $option,
			'approvalNotesProvider' => $approvalNotesProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing Quotation model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{	
		$model = $this->findModel($id);
		$lines = QuotationProducts::find()->where(['QuotationID' => $id])->all();
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) 
		{
			$params = Yii::$app->request->post();
			$lines = $params['QuotationProducts'];
			
			foreach ($lines as $key => $line)
			{
				//print_r($lines);exit;
					
				if ($line['RequisitionLineID'] == '')
				{				
					if ($line['ProductID'] != '')
					{
						$_line = new QuotationProducts();
						$_line->QuotationID = $id;
						$_line->ProductID = $line['ProductID'];
						$_line->Quantity = $line['Quantity'];
						$_line->Description = $line['Description'];
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else {
					$_line = QuotationProducts::findOne($line['RequisitionLineID']);
					$_line->QuotationID = $id;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->save();
				}
			}
		
			return $this->redirect(['view', 'id' => $model->QuotationID]);
		} else {
			$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
			$modelcount = count($lines);
			for ($x = $modelcount; $x <= 9; $x++) { 
				$lines[$x] = new QuotationProducts();
			}
		
			return $this->render('update', [
				'model' => $model, 'lines' => $lines, 'products' => $products,
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
		if (($model = ProcurementPlanLines::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
