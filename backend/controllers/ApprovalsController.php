<?php

namespace backend\controllers;

use Yii;
use app\models\Requisition;
use app\models\RequisitionLine;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\StockAdjustment;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\UsersController;
use backend\controllers\RightsController;

/**
 * RequisitionController implements the CRUD actions for Requisition model.
 */
class ApprovalsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
		'access' => [
					'class' => AccessControl::className(),
					'only' => ['index', 'view', 'create', 'update', 'delete'],
					'rules' => [
				/*
				// Guest Users
						[
							'allow' => true,
							'actions' => ['login', 'signup'],
							'roles' => ['?'],
						], */
				// Authenticated Users
						[
							'allow' => true,
							'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
	 * Lists all Requisition models.
	 * @return mixed
	 */
	public function actionIndex($option)
	{
		$StatusID = $option==1 ? 1 : 2;
		$dataProvider = new ActiveDataProvider([
			'query' => Requisition::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'option' => $option,
		]);
	}

	/**
	 * Displays a single Requisition model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id, $option)
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		
		$params = Yii::$app->request->post();
		$dataProvider = new ActiveDataProvider([
				'query' => RequisitionLine::find()->joinWith('product')->where(['RequisitionID'=> $id]),
			]);
		$model = $this->findModel($id);

		$notes = new ApprovalNotes();
		if (Yii::$app->request->post()) {
			if ($params['option']==1 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 2;
			} else if ($params['option']==2 && isset($params['Approve'])) {
				$model->ApprovalStatusID = 3;

				$model->PostingDate = date('Y-m-d h:i:s');
				$model->Posted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');
			}
			
			if (isset($params['Reject'])) {
				$model->ApprovalStatusID = 4;
			}
		}

		if (Yii::$app->request->post() && $model->save()) {
			$params = Yii::$app->request->post();
			
			// Add Notes to the notes table
			$notes->Note = $params['ApprovalNotes']['Note'];
			$notes->ApprovalStatusID = $model->ApprovalStatusID;
			$notes->ApprovalTypeID = 1;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			$notes->save();
			
			// Make adjustment to the stock
			$lines = RequisitionLine::find()->where(['RequisitionID'=> $id])->all();
			foreach ($lines as $key => $line)
			{
				$stock = new StockAdjustment();
				$stock->AdjustmentTypeID = 3;
				$stock->AdjustmentID = $id;
				$stock->Quantity = $line->Quantity*-1;
				$stock->ProductID = $line->ProductID;
				$stock->save();
			}
			if ($model->ApprovalStatusID ==2) {
				$result = UsersController::sendEmailNotification(12); 
			}
			return $this->redirect(['index', 'option'=> $option]);
		}

		$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where("ApprovalStatusID > 1")->all(), 'ApprovalStatusID', 'ApprovalStatusName');
		$detailmodel = Requisition::find()->where(['RequisitionID'=> $id])->joinWith('approvalstatus')->one();
		return $this->render('view', [
			'model' => $model,'detailmodel' => $detailmodel, 'dataProvider' => $dataProvider, 
			'approvalstatus' => $approvalstatus, 'notes' => $notes, 'option' => $option,
		]);
	}

	/**
	 * Updates an existing Requisition model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{	
		$model = $this->findModel($id);	
		$lines = RequisitionLine::find()->where(['RequisitionID' => $id])->all();
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['RequisitionLine'];
		
			foreach ($lines as $key => $line) {
				//print_r($lines);exit;
					
				if ($line['RequisitionLineID'] == '') {
					if ($line['ProductID'] != '') {
						$_line = new RequisitionLine();
						$_line->RequisitionID = $id;
						$_line->ProductID = $line['ProductID'];
						$_line->Quantity = $line['Quantity'];
						$_line->Description = $line['Description'];
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else {
					$_line = RequisitionLine::findOne($line['RequisitionLineID']);
					$_line->RequisitionID = $id;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->save();
				}
			}
		
			return $this->redirect(['view', 'id' => $model->RequisitionID]);
		}

		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$modelcount = count($lines);
		for ($x = $modelcount; $x <= 9; $x++) { 
			$lines[$x] = new RequisitionLine();
		}
		
		return $this->render('update', [
				'model' => $model, 'lines' => $lines, 'products' => $products
		]);
	}

	/**
	 * Deletes an existing Requisition model.
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
	 * Finds the Requisition model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Requisition the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Requisition::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
