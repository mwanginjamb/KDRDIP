<?php

namespace backend\controllers;

use Yii;
use app\models\Invoices;
use app\models\DeliveryLines;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\Purchases;
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
class InvoiceApprovalsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(24);

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
		$StatusID = $option; //==1 ? 1 : 2;
		$dataProvider = new ActiveDataProvider([
			'query' => Invoices::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'option' => $option,
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
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		$model = $this->findModel($id);
		$model->submit = 1;
		$purchases = [];
		$deliveries = [];
		
		$params = Yii::$app->request->post();
		$PurchaseID = $model->PurchaseID;
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
				$model->ApprovalStatusID = 2;
			} elseif ($params['option']==2 && isset($params['Approve'])) {
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
			$notes->ApprovalTypeID = 5;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			$notes->save();
			
			if ($model->ApprovalStatusID ==3) {
				// $result = UsersController::sendEmailNotification(12);
			}
			return $this->redirect(['index', 'option'=> $option]);
		}

		$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where('ApprovalStatusID > 1')->all(), 'ApprovalStatusID', 'ApprovalStatusName');
		$detailmodel = Invoices::find()->where(['InvoiceID'=> $id])->joinWith('approvalstatus')->one();
		return $this->render('view', [
			'model' => $model,
			'detailmodel' => $detailmodel,
			'deliveries' => $deliveries,
			'approvalstatus' => $approvalstatus,
			'notes' => $notes,
			'option' => $option,
			'purchases' => $purchases,
			'rights' => $this->rights,
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
		if (($model = Invoices::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
