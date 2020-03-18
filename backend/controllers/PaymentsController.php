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
use backend\controllers\ReportsController;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use kartik\mpdf\Pdf;

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
		// print('<pre>');
		// print_r($params); exit;
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

		if (isset($params['export'])) {
			return $this->export($where);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find()->where($where),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
			'rights' => $this->rights,
		]);

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
			'invoice' => $invoice,
			'rights' => $this->rights,
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
			'bankAccounts' => $bankAccounts,
			'rights' => $this->rights,
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
		$sql = "SELECT InvoiceID, CONCAT('InvID: ',InvoiceID, ' - ', COALESCE(format(`Amount`,2), format(0,2))) as InvoiceName FROM invoices
					WHERE SupplierID = $supplierID";
		$invoices = ArrayHelper::map(Invoices::findBySql($sql)->asArray()->all(), 'InvoiceID', 'InvoiceName');

		return $this->render('update', [
			'model' => $model,
			'suppliers' => $suppliers,
			'invoices' => $invoices,
			'paymentMethods' => $paymentMethods,
			'bankAccounts' => $bankAccounts,
			'rights' => $this->rights,
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

	public static function export($where) {
		$model = Payments::find()->joinWith('suppliers')
											->joinWith('paymentMethods')
											->joinWith('approvalstatus')
											->select(
												[	
													'Date', 
													'suppliers.SupplierID', 
													'suppliers.SupplierName', 
													'paymentMethods.PaymentMethodID',
													'paymentMethods.PaymentMethodName',
													'approvalstatus.ApprovalStatusID',
													'approvalstatus.ApprovalStatusName',
													'ApprovalDate'
												])
											->asArray()
											->all();
		$diplayFields = ['Date', 'SupplierName', 'PaymentMethodName', 'ApprovalStatusName', 'ApprovalDate'];
		return ReportsController::WriteExcel($model, 'Payment Report', $diplayFields);
	}

	public function actionPaymentVoucher($id)
	{
		$model = Payments::find()->where(['PaymentID' => $id])
										->joinWith('suppliers')
										->joinWith('bankAccounts')
										->joinWith('paymentMethods')
										->one();
		$Title = 'Payment Voucher';
		$amountWords = $this->convert_number_to_words($model->Amount);

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('paymentvoucher', ['model' => $model, 'amountWords' => $amountWords]);

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE, 
			// A4 paper format
			'format' => Pdf::FORMAT_A4, 
			// portrait orientation
			'orientation' => Pdf::ORIENT_PORTRAIT, 
			// stream to browser inline
			'destination' => Pdf::DEST_STRING, 
			// your html content input
			'content' => $content,  
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting 
			'cssFile' => 'css/pdf.css',
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}', 
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [ 
				// 'SetHeader'=>[$Title], 
				// 'SetFooter'=>['{PAGENO}'],
			]
		]);
		// $pdf->SetTitle('My Title');
		
		// return the pdf output as per the destination setting
		//return $pdf->render(); 
		$content = $pdf->render('', 'S'); 
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', ['content' => $content, 'model' => $model]);
	}

	function convert_number_to_words($number) {

		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
					'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
					E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
					$string = $dictionary[$number];
					break;
			case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
			case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . $this->convert_number_to_words($remainder);
					}
					break;
			default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= $this->convert_number_to_words($remainder);
					}
					break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}

		return $string;
	}
}
