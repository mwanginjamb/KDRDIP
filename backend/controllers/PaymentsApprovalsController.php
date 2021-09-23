<?php

namespace backend\controllers;

use Yii;
use app\models\Payments;
use app\models\CashBook;
use app\models\Documents;
use app\models\DeliveryLines;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\Purchases;
use app\models\Invoices;
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
class PaymentsApprovalsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(29);

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
	 * Lists all Invoices models.
	 * @return mixed
	 */
	public function actionIndex($option)
	{
		$StatusID = $option==1 ? 1 : 2;
		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'option' => $option,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Requisition model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id, $option)
	{		
		$UserID = Yii::$app->user->identity->UserID;		
		$model = $this->findModel($id);
		$invoice = Invoices::findOne($model->InvoiceID);
		$PurchaseID = null;
		if ($invoice) {
			$PurchaseID = $invoice->PurchaseID;
		} else {
			$invoice = [];  
		}	
		
		$params = Yii::$app->request->post();
		// $PurchaseID = $invoice->PurchaseID;
		$purchases = [];
		$deliveries = [];
		if ($PurchaseID) {
			$sql ="select * from deliverylines
					join deliveries on deliveries.DeliveryID = deliverylines.DeliveryID
					join purchaselines on purchaselines.PurchaseLineID = deliverylines.PurchaseLineID
					join product on product.ProductID = purchaselines.ProductID
					WHERE deliveries.PurchaseID = $PurchaseID
					ORDER BY deliveries.DeliveryID";
			$deliveries = DeliveryLines::findBySql($sql)->asArray()->all();

			$sql ="select * from purchaselines
			LEFT Join purchases on purchases.PurchaseID = purchaselines.PurchaseID
			LEFT JOIN product on product.ProductID = purchaselines.ProductID
			WHERE purchases.PurchaseID = $PurchaseID";

			$purchases = Purchases::findBySql($sql)->asArray()->all();
		}
		
		$notes = new ApprovalNotes();
		if (Yii::$app->request->post()) {
			if ($params['option']==1 && isset($params['Approve'])) {
                $model->ApprovalStatusID = 3;

                $cashBook = new CashBook();
				$cashBook->CreatedBy = Yii::$app->user->identity->UserID;
				$cashBook->Date = $model['Date'];
				$cashBook->TypeID = 1;
				$cashBook->BankAccountID = $model['BankAccountID'];
				$cashBook->AccountID = $model['BankAccountID'];
				$cashBook->Description = $model['Description'];
				$cashBook->DocumentReference = $model['RefNumber'];
				$cashBook->ProjectID = $model['ProjectID'];
				// $cashBook->OrganizationID = $model['OrganizationID'];
				// $cashBook->CountyID = $model['CountyID'];
				$cashBook->ProjectDisbursementID = 0;
				$cashBook->Credit = $model['Amount'];
				$cashBook->Amount = $model['Amount'];
				if (!$cashBook->save()) {
					// print_r($cashBook->getErrors()); exit;
				}

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
			$notes->ApprovalTypeID = 6;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			$notes->save();
			
			if ($model->ApprovalStatusID ==3) {
				// $result = UsersController::sendEmailNotification(12);
			}
			return $this->redirect(['index', 'option'=> $option]);
		}

		$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where('ApprovalStatusID > 1')->all(), 'ApprovalStatusID', 'ApprovalStatusName');
		$detailmodel = Payments::find()->where(['PaymentID'=> $id])->joinWith('approvalstatus')->one();

		$approvalNotesProvider = new ActiveDataProvider([
			'query' => ApprovalNotes::find()->where(['ApprovalID'=> $id, 'ApprovalTypeID' => 6]),
		]);

		
		$documentsProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $id, 'DocumentCategoryID' => 8]),
		]);

		return $this->render('view', [
			'model' => $model,
			'detailmodel' => $detailmodel,
			'deliveries' => $deliveries,
			'approvalstatus' => $approvalstatus,
			'notes' => $notes,
			'option' => $option,
			'purchases' => $purchases,
			'invoice' => $invoice,
			'rights' => $this->rights,
			'approvalNotesProvider' => $approvalNotesProvider,
			'documentsProvider' => $documentsProvider,
		]);
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
		if (($model = Payments::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
