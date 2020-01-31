<?php

namespace backend\controllers;

use Yii;
use app\models\Payments;
use app\models\PaymentMethods;
use app\models\DeliveryLines;
use app\models\Purchases;
use app\models\Invoices;
use app\models\Suppliers;
use app\models\BankAccounts;
use app\models\Search;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * PaymentsController implements the CRUD actions for Payments model.
 */
class PaymentsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(30);

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
	 * Lists all Payments models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchfor = [1 => 'ID', 2 => 'Supplier', 3 => 'RefNumber', 4 => 'Amount'];
		$search = new Search();
		$params = Yii::$app->request->post();
		$where = '';
		if (!empty($params)) {
			if ($params['Search']['searchfor'] == 1) {
				$searchstring = $params['Search']['searchstring'];
				$where = "PaymentID = '$searchstring'";
			} elseif ($params['Search']['searchfor'] == 2) {
				$searchstring = $params['Search']['searchstring'];
				$where = ""; // "suppliers like '%$searchstring%' || MiddleName like '%$searchstring%' || LastName like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 3) {
				$searchstring = $params['Search']['searchstring'];
				$where = "RefNumber like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 4) {
				$searchstring = $params['Search']['searchstring'];
				$where = "Amount like '%$searchstring%'";
			}
			$search->searchfor = $params['Search']['searchfor'];
			$search->searchstring = $params['Search']['searchstring'];
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find()->where($where),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
		]);
/* 		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]); */
	}

	/**
	 * Displays a single Payments model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$invoice = Invoices::findOne($model->InvoiceID);
		$PurchaseID = $invoice->PurchaseID;

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

		return $this->render('view', [
			'model' => $this->findModel($id),
			'purchases' => $purchases,
			'deliveries' => $deliveries,
			'invoice' => $invoice
		]);
	}

	/**
	 * Creates a new Payments model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Payments();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->PaymentID]);
		}

		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$invoices = []; //ArrayHelper::map(Invoices::find()->all(), 'InvoiceID', 'InvoiceID');
		$paymentMethods = ArrayHelper::map(PaymentMethods::find()->all(), 'PaymentMethodID', 'PaymentMethodName');
		$bankAccounts = ArrayHelper::map(BankAccounts::find()->all(), 'BankAccountID', 'AccountName');

		return $this->render('create', [
			'model' => $model,
			'suppliers' => $suppliers,
			'invoices' => $invoices,
			'paymentMethods' => $paymentMethods,
			'bankAccounts' => $bankAccounts
		]);
	}

	/**
	 * Updates an existing Payments model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->PaymentID]);
		}
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		// $invoices = ArrayHelper::map(Invoices::find()->all(), 'InvoiceID', 'InvoiceID');
		$paymentMethods = ArrayHelper::map(PaymentMethods::find()->all(), 'PaymentMethodID', 'PaymentMethodName');
		$bankAccounts = ArrayHelper::map(BankAccounts::find()->all(), 'BankAccountID', 'AccountName');
		$supplierID = $model->SupplierID;
		$sql = "SELECT InvoiceID, CONCAT('InvID: ',InvoiceID, ' - ', COALESCE(format(`Amount`,2), format(0,2))) as InvoiceName FROM mande.invoices
					WHERE SupplierID = $supplierID";
		$invoices = ArrayHelper::map(Invoices::findBySql($sql)->asArray()->all(), 'InvoiceID', 'InvoiceName');

		return $this->render('update', [
			'model' => $model,
			'suppliers' => $suppliers,
			'invoices' => $invoices,
			'paymentMethods' => $paymentMethods,
			'bankAccounts' => $bankAccounts
		]);
	}

	/**
	 * Deletes an existing Payments model.
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
	 * Finds the Payments model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Payments the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Payments::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		if ($model->save() && $model) {
			$result = UsersController::sendEmailNotification(29);
			return $this->redirect(['view', 'id' => $model->PaymentID]);
		} else {
			// print_r($model->getErrors()); exit;
		}
	}

	public function actionInvoices($id)
	{
		$sql = "SELECT InvoiceID, CONCAT('Inv No.: ',InvoiceID, ' - ', COALESCE(format(`Amount`,2), format(0,2))) as InvoiceName 
					FROM invoices
					WHERE SupplierID = $id"; 
		$model = Invoices::findBySql($sql)->asArray()->all();
		echo '<option></option>';	
		if (!empty($model)) {
			foreach ($model as $item) {
				echo "<option value='" . $item['InvoiceID'] . "'>" . $item['InvoiceName'] . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}
}
