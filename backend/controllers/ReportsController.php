<?php

namespace backend\controllers;

use Yii;
use app\models\Product;
use app\models\Usageunit;
use app\models\UploadFile;
use app\models\Purchases;
use app\models\FilterData;
use app\models\ProductCategory;
use app\models\StockTakeLines;
use app\models\StockTake;
use app\models\PurchaseLines;
use app\models\Suppliers;
use app\models\FixedAssets;
use app\models\Payments;
use app\models\BankAccounts;
use app\models\Indicators;
use app\models\ReportingPeriods;
use app\models\IndicatorTargets;
use app\models\IndicatorActuals;
use app\models\Projects;
use app\models\Activities;
use app\models\ActivityBudget;
use app\models\ProjectStatus;
use app\models\FundsRequisition;
use app\models\Counties;
use app\models\SubCounties;
use app\models\Locations;
use app\models\SubLocations;
use app\models\ProjectSectors;
use app\models\Components;
use app\models\SubComponentCategories;
use app\models\EnterpriseTypes;
use app\models\ProcurementPlan;
use app\models\ProcurementPlanLines;
use app\models\ProcurementActivityLines;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * RequisitionController implements the CRUD actions for Requisition model.
 */
class ReportsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(44);

		$rightsArray = [];
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view', 'purchasesreport', 'inventoryreport', 'stocktakingreport');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create', 'purchasesreport', 'inventoryreport', 'stocktakingreport');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update', 'purchasesreport', 'inventoryreport', 'stocktakingreport');
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
			'only' => ['index', 'view', 'create', 'update', 'delete', 'purchasesreport', 'inventoryreport', 'stocktakingreport'],
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
	 * Lists all Product models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Product::find()->joinWith('productcategory')->joinWith('usageunit'),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Product model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => Product::find()->where(['ProductID'=>$id])->joinWith('productcategory')->joinWith('usageunit')->one(),
			'rights' => $this->rights,
		]);
	}

	public function actionReport()
	{
		$id = 2;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('report', ['model' => Product::find()->where(['ProductID'=>$id])->joinWith('productcategory')->joinWith('usageunit')->one()]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => 'Krajee Report Title'],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>['Krajee Report Header'],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content,
			]);
	}

	public function actionPurchasesreport()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		if (!empty($params)) {
			$Year = $params['FilterData']['Year'];
			$Month = $params['FilterData']['Month'];
			
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			$FilterString = "WHERE YEAR(PostingDate) = '" . $params['FilterData']['Year'] . "'";
				
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0)) {
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0)) {
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Purchase Report';
		$sql = "SELECT * FROM (
				SELECT ProductID, Sum(Quantity) as Quantity, sum(Quantity * UnitPrice) as LineAmount FROM purchaselines
				JOIN purchases ON purchases.PurchaseID = purchaselines.PurchaseID
				$FilterString
				GROUP BY ProductID
				) temp 
				JOIN product ON product.ProductID = temp.ProductID
				JOIN productcategory ON productcategory.ProductCategoryID = product.ProductCategoryID
				JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				$FilterString2
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('purchasesreport', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => false,
			]);
	}

	public function actionInventoryreport()
	{
		
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		if (!empty($params)) {
			//$Year = $params['FilterData']['Year'];
			//$Month = $params['FilterData']['Month'];
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			//$FilterString = "WHERE YEAR(PostingDate) = '".$params['FilterData']['Year']."'";
			
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0)) {
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			/*
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0))
			{
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
			*/
		}
		$Title = 'Inventory Report';
		$sql = "SELECT * FROM (
				SELECT ProductID, sum(Quantity) as Quantity FROM 
					(

					SELECT ProductID, sum(Quantity) as Quantity FROM stockadjustment
					GROUP BY ProductID
					) as temp0 group by ProductID
				) as temp 
				JOIN product ON product.ProductID = temp.ProductID
				JOIN productcategory ON productcategory.ProductCategoryID = product.ProductCategoryID
				JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				$FilterString2
				";
		//print_r($sql); exit;

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		//print_r( $products ); exit;
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('inventoryreport', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => true,
			]);
	}

	public function actionStocktakingreport()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		if (!empty($params)) {
			//$Year = $params['FilterData']['Year'];
			//$Month = $params['FilterData']['Month'];
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0)) {
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0)) {
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Stock Taking Sheets';
		$sql = "SELECT *, '' AS Qty FROM product 
				JOIN productcategory ON productcategory.ProductCategoryID = product.ProductCategoryID
				JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				$FilterString2
				ORDER BY ProductCategoryName, ProductName
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		//print_r( $products ); exit;
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('stocktakingreport', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => true,
		]);
	}

	public function actionStockvariancereport()
	{
		$params = Yii::$app->request->post();
		$StockTakeID = 0;
		if (!empty($params)) {
			$StockTakeID = $params['FilterData']['StockTakeID'];
		}
		$Title = 'Stock Variance Report';
		$sql = "SELECT * , physicalstock-CurrentStock as Variance FROM stocktakelines
				LEFT JOIN product ON product.ProductID = stocktakelines.ProductID
				LEFT JOIN productcategory ON productcategory.ProductCategoryID = product.ProductCategoryID
				LEFT JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				WHERE stocktakelines.StockTakeID = '$StockTakeID'
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => StockTakeLines::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$stocktake = ArrayHelper::map(StockTake::find()->all(), 'StockTakeID', 'Reason');
		
		//print_r($stocktake); Exit;
		$months = [];
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->StockTakeID = $StockTakeID;
		
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('stockvariancereport', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'stocktake' => $stocktake, 'Filter' => true, 'CategoryFilterOnly' => true, 'StockFilter' => true,
		]);
	}

	public function actionPuchasesummaryreport()
	{
		$months = [];
		$years = [];
		ini_set('memory_limit', '512M');
		$params = Yii::$app->request->post();
		$SupplierID = 0;
		$wherestr = 'WHERE ProductName is not Null ';
		if (!empty($params)) {
			if (isset($params['FilterData']['SupplierID']) && $params['FilterData']['SupplierID'] != '') {
				$SupplierID = $params['FilterData']['SupplierID'];
				$wherestr = " AND purchases.SupplierID = '$SupplierID' AND ProductName is not Null";
			}
		}
		
		$Title = 'Stock Variance Report';
		$sql = "SELECT *, purchaselines.UnitPrice * Quantity as Total  FROM purchaselines
				LEFT JOIN purchases ON purchases.PurchaseID = purchaselines.PurchaseID
				LEFT JOIN product ON product.ProductID = purchaselines.ProductID
				LEFT JOIN productcategory ON productcategory.ProductCategoryID = product.ProductCategoryID
				$wherestr
				ORDER BY ProductCategoryName
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => PurchaseLines::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');

		$model = new FilterData();
		$model->SupplierID = $SupplierID;
		
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('purchasesummaryreport', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'suppliers' => $suppliers, 'Filter' => true, 'CategoryFilterOnly' => true, 'SupplierFilter' => true,
			]);
	}
		
	public function actionSupplierbalances()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		if (!empty($params)) {
			$Year = $params['FilterData']['Year'];
			$Month = $params['FilterData']['Month'];
			
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			$FilterString = "WHERE YEAR(PostingDate) = '" . $params['FilterData']['Year'] . "'";
				
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0)) {
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0)) {
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Supplier Balances';
		$sql = 'SELECT sum(Amount) as Amount, Temp.SupplierID, SupplierName FROM 
				(
				Select sum(Quantity * UnitPrice * -1) AS Amount, SupplierID FROM purchaselines
				JOIN purchases ON purchases.PurchaseID = purchaselines.PurchaseID
				WHERE ApprovalStatusID = 3
				GROUP BY SupplierID
				UNION
				(
					SELECT sum(Amount) AS Amount, SupplierID from payments
					GROUP BY SupplierID
				)
				UNION
				(
					SELECT sum(Quantity*UnitPrice) AS Amount, SupplierID from creditnotelines
					JOIN creditnotes ON creditnotes.CreditNoteID = creditnotelines.CreditNoteID
					GROUP BY SupplierID	
				)
				) as Temp
				JOIN suppliers ON suppliers.SupplierID = Temp.SupplierID
				GROUP BY Temp.SupplierID, SupplierName
				';

		$dataProvider = new ArrayDataProvider([
				'allModels' => Suppliers::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('supplierbalances', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => false, 'CategoryFilterOnly' => false,
			]);
	}

	public function actionSupplierstatement()
	{
		$params = Yii::$app->request->post();
		
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		$SupplierID = 0;
		$where = 'WHERE 1 = 1 ';
		if (!empty($params)) {
			$Year = isset($params['FilterData']['Year']) ? $params['FilterData']['Year'] : $Year = date('Y');
			$Month = isset($params['FilterData']['Month']) ? $params['FilterData']['Month'] : $Month = date('m');
			
			$ProductCategoryID = isset($params['FilterData']['ProductCategoryID']) ? $params['FilterData']['ProductCategoryID'] : 0;
			
			$SupplierID = (isset($params['FilterData']['SupplierID']) && $params['FilterData']['SupplierID'] != '') ? $params['FilterData']['SupplierID'] : 0;
			$ProjectID = (isset($params['FilterData']['ProjectID']) && $params['FilterData']['ProjectID'] != '') ? $params['FilterData']['ProjectID'] : 0;
			
			$FilterString = "WHERE YEAR(PostingDate) = '$Year'";
				
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0)) {
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0)) {
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}

			$where = 'WHERE 1 = 1 ';
			if ($SupplierID != 0) {
				$where .= " AND SupplierID = $SupplierID";
			}

			if ($ProjectID != 0) {
				// $where .= " AND ProjectID = $ProjectID";
			}
		}
		$Title = 'Supplier Statement';
		$sql = "SELECT Amount, Temp.SupplierID, CreatedDate, Description FROM 
				(
				Select (Quantity*UnitPrice*-1) AS Amount, SupplierID, purchases.CreatedDate, concat('Purchase LPO : ', purchases.PurchaseID) as Description FROM purchaselines
				JOIN purchases ON purchases.PurchaseID = purchaselines.PurchaseID
				WHERE ApprovalStatusID = 3
				UNION
				(
					SELECT Amount, SupplierID, CreatedDate, concat('Deposit Ref. : ', PaymentID) as Description from payments
				)
				UNION
				(
					SELECT (Quantity*UnitPrice) AS Amount, SupplierID, creditnotes.CreatedDate, concat('Credit Note Ref. ', creditnotes.CreditNoteID) as Description 
					from creditnotelines
					JOIN creditnotes ON creditnotes.CreditNoteID = creditnotelines.CreditNoteID
				)
				) as Temp
				$where
				ORDER BY CreatedDate Desc
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Purchases::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		
		$supplier = Suppliers::findOne($SupplierID);
		
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('supplierstatement', ['dataProvider' => $dataProvider, 'supplier' => $supplier]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years, 'suppliers' => $suppliers,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => true,
			'SupplierFilter' => true, 'projects' => $projects
			]);
	}

	public function actionStockreport()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		if (!empty($params)) {
			//$Year = $params['FilterData']['Year'];
			//$Month = $params['FilterData']['Month'];
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0)) {
				$FilterString2 .= ' WHERE product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0)) {
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Stock Report';
		$sql = "Select Temp.ProductID, ProductName, ProductCategoryName, sum(Ordered) as Ordered, sum(Issued) as Issued, sum(Ordered)-sum(Issued) as Balance  FROM 
					(
						SELECT ProductID, sum(Quantity) AS Ordered, 0 as Issued FROM purchaselines
						WHERE ProductID is not Null
						GROUP BY ProductID
						UNION
						(
						SELECT ProductID, 0 as Ordered, sum(Quantity) as Issued FROM requisitionline
						WHERE ProductID is not Null
						GROUP BY ProductID
						)
					) as Temp
					JOIN product ON product.ProductID = Temp.ProductID
					JOIN productcategory ON productcategory.ProductCategoryID = product.ProductCategoryID
					$FilterString2
					GROUP BY ProductCategoryName, ProductName,Temp.ProductID
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		//print_r( $products ); exit;
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('stockreport', ['dataProvider' => $dataProvider]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => true,
			]);
	}

	public function actionAssetRegister()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = '';
		$productcategories =[];
		
		$Title = 'Asset Register';
		/*
		$dataProvider = new ArrayDataProvider([
				'allModels' => FixedAssets::find()->asArray()->all(), 'pagination' => false,
			]); */
		$dataProvider = new ActiveDataProvider([
			'query' => FixedAssets::find(),
			'pagination' => false,
		]);
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->ProductCategoryID = $ProductCategoryID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('asset-register', ['dataProvider' => $dataProvider]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => true,
			]);
	}

	public function actionBankTransactions()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$BankAccountID = 0;
		$FilterString2 = '';
		$productcategories =[];
		$bankAccounts = ArrayHelper::map(BankAccounts::find()->all(), 'BankAccountID', 'AccountName');
		
		$Title = 'Bank Transactions';

		$wherestr = 'payments.Deleted = 0';
		if (!empty($params)) {
			if (isset($params['FilterData']['BankAccountID']) && $params['FilterData']['BankAccountID'] != '') {
				$BankAccountID = $params['FilterData']['BankAccountID'];
				$wherestr .= " AND payments.BankAccountID = '$BankAccountID'";
			}
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find()->joinWith('bankAccounts')->joinWith('bankAccounts.banks')->where("$wherestr"),
			'pagination' => false,
		]);
		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}
		$model = new FilterData();
		$model->Month = $Month;
		$model->Year = $Year;
		$model->BankAccountID = $BankAccountID;
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('bank-transactions', ['dataProvider' => $dataProvider]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true, 'CategoryFilterOnly' => true,
			'bankAccounts' => $bankAccounts
		]);
	}

	// Project Reports

	public function actionProgressReport($cid)
	{
		$params = Yii::$app->request->post();
		$projectsModel = Projects::find()->where(['ComponentID' => $cid])->all();
		$projects = ArrayHelper::map($projectsModel, 'ProjectID', 'ProjectName');

		$ProjectID = 1;
		if (!empty($params) && isset($params['FilterData']['ProjectID'])) {
			$ProjectID = $params['FilterData']['ProjectID'];
		} else {
			$ProjectID = (!empty($projectsModel)) ? $projectsModel[0]->ProjectID : 0;
		}
		
		$Title = 'Projects Performance';
		$indicators = Indicators::find()->joinWith('unitsOfMeasure')->joinWith('projects')
													->where(['projects.ProjectID' => $ProjectID])
													->asArray()
													->orderBy('projects.ProjectID')
													->all();

		$reportingPeriods = ReportingPeriods::find()->where(['ProjectID'=> $ProjectID])->all();

		$indicatorTargets = IndicatorTargets::find()->joinWith('indicators')
									->where(['indicators.ProjectID' => $ProjectID])->asArray()->all();
		$targets = ArrayHelper::index($indicatorTargets, 'ReportingPeriodID', [
			function ($element) {
				return $element['IndicatorID'];
			}]);

		$indicatorActuals = IndicatorActuals::find()->joinWith('indicators')
				->where(['indicators.ProjectID' => $ProjectID])->asArray()->all();
		$actuals = ArrayHelper::index($indicatorActuals, 'ReportingPeriodID', [
			function ($element) {
					return $element['IndicatorID'];
			}]);

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('progress-report', [
																			'indicators' => $indicators,
																			'reportingPeriods' => $reportingPeriods,
																			'targets' => $targets,
																			'actuals' => $actuals,
																			'project' => Projects::findOne($ProjectID),
																		]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = 1;
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true, 'projects' => $projects,
			'bankAccounts' => $bankAccounts
		]);
	}

/* 	public static function getSelected($model, $id)
	{
		foreach ()
	}
 */
	public function actionProjectsReport($cid)
	{
		$Title = 'Projects Report';

		$projectStatus = ArrayHelper::map(ProjectStatus::find()->all(), 'ProjectStatusID', 'ProjectStatusName');
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');

		$ProjectStatusID = 0;
		$SubLocationID = 0;
		$SubCountyID = 0;
		$LocationID = 0;
		$CountyID = 0;
		$ProjectSectorID = 0;

		$model = new FilterData();
		$ComponentID = $cid;
		if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
			$params = Yii::$app->request->post()['FilterData'];
			// print_r($params);
			//  exit;
			$ProjectStatusID = isset($params['ProjectStatusID']) && $params['ProjectStatusID'] != '' ? $params['ProjectStatusID'] : 0;
			$ComponentID = isset($params['ComponentID']) && $params['ComponentID'] != '' ? $params['ComponentID'] : 0;
			$SubLocationID = isset($params['SubLocationID']) && $params['SubLocationID'] != '' ? $params['SubLocationID'] : 0;
			$SubCountyID = isset($params['SubCountyID']) && $params['SubCountyID'] != '' ? $params['SubCountyID'] : 0;
			$LocationID = isset($params['LocationID']) && $params['LocationID'] != '' ? $params['LocationID'] : 0;
			$CountyID = isset($params['CountyID']) && $params['CountyID'] != '' ? $params['CountyID'] : 0;
			$ProjectSectorID = isset($params['ProjectSectorID']) && $params['ProjectSectorID'] != '' ? $params['ProjectSectorID'] : 0;
		}
		
		$projectSectors = ArrayHelper::map(ProjectSectors::find()->all(), 'ProjectSectorID', 'ProjectSectorName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->where(['LocationID' => $model->SubCountyID ])->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->LocationID ])->all(), 'SubLocationID', 'SubLocationName');
	
		$projects = Projects::find()->joinWith('components')->joinWith('projectStatus');
		$where = '';
		if ($ProjectStatusID != 0) {
			$projects->andWhere(['projects.ProjectStatusID' => $ProjectStatusID])->all();
			$where .= " AND projects.ProjectStatusID = $ProjectStatusID ";
		}
		if ($ComponentID != 0) {
			$projects->andWhere(['projects.ComponentID' => $ComponentID])->all();
			$where .= " AND projects.ComponentID = $ComponentID ";
		}
		if ($SubLocationID != 0) {
			$projects->andWhere(['projects.WardID' => $SubLocationID])->all();
			$where .= " AND projects.WardID = $SubLocationID ";
		}
		if ($SubCountyID != 0) {
			$projects->andWhere(['projects.SubCountyID' => $SubCountyID])->all();
			$where .= " AND projects.SubCountyID = $SubCountyID ";
		}
		if ($LocationID != 0) {
			$projects->andWhere(['projects.LocationID' => $LocationID])->all();
			$where .= " AND projects.LocationID = $LocationID ";
		}
		if ($CountyID != 0) {
			$projects->andWhere(['projects.CountyID' => $CountyID])->all();
			$where .= " AND projects.CountyID = $CountyID ";
		}
		if ($ProjectSectorID != 0) {
			$projects->andWhere(['projects.ProjectSectorID' => $ProjectSectorID])->all();
			$where .= " AND projects.ProjectSectorID = $ProjectSectorID ";
		}

		$projects = $projects->OrderBy('componentID')->all();

		$sql = 'select temp.Total, projectstatus.ProjectStatusID, ProjectStatusName, ColorCode FROM (
					select ProjectStatusID, count(*) as Total from projects
					where projects.Deleted = 0 ' . $where . '
					GROUP BY ProjectStatusID
					) temp
					right JOIN projectstatus on projectstatus.ProjectStatusID = temp.ProjectStatusID';
		// echo $sql; exit;

		$statuses = ProjectStatus::findBySql($sql)->asArray()->all();

		$pStatus = ProjectStatus::findOne($ProjectStatusID);
		$projectStatusName = !empty($pStatus) ? $pStatus->ProjectStatusName : 'All';

		$filter = [
			'Project Status' => isset($projectStatus[$model->ProjectStatusID]) ? $projectStatus[$model->ProjectStatusID] : 'All',
			'Component' => isset($components[$model->ComponentID]) ? $components[$model->ComponentID] : 'All',
			'Project Sector' => isset($projectSectors[$model->ProjectSectorID]) ? $projectSectors[$model->ProjectSectorID] : 'All',
			'County' => isset($counties[$model->CountyID]) ? $counties[$model->CountyID] : 'All',
			'Sub County' => isset($subCounties[$model->SubCountyID]) ? $subCounties[$model->SubCountyID] : 'All',
			'Location' => isset($locations[$model->LocationID]) ?  $locations[$model->LocationID] : 'All',
			'SubLocation' => isset($subLocations[$model->SubLocationID]) ? $subLocations[$model->SubLocationID] : 'All',
		];

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('projects-report', [
																				'projectStatus' => $projectStatus,
																				'projects' => $projects,
																				'projectStatusName' => $projectStatusName,
																				'statuses' => $statuses,
																				'filter' => $filter,
																			]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader' => [$Title . '||Generated On: ' . date('d M Y h:m a')],
				'SetFooter'=>['Page {PAGENO} ||Generate By: ' . Yii::$app->user->identity->FirstName . ' ' . Yii::$app->user->identity->LastName],
			]
		]);

		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		// $model = new FilterData();
		$model->ProjectID = 0;
		$model->ProjectStatusID = $ProjectStatusID;
		$model->ComponentID = $ComponentID;
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'months' => $months,
			'years' => $years,
			'model' => $model,
			'productcategories' => $productcategories,
			'Filter' => true,
			'CategoryFilterOnly' => true,
			'projectStatus' => $projectStatus,
			'projects' => [],
			'bankAccounts' => $bankAccounts,
			'components' => $components,
			'report' => 'projects-report',
			'projectSectors' => $projectSectors,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	public function actionProjectsFinance($cid)
	{
		$params = Yii::$app->request->post();
		$Title = 'Project Finance Report';

		$projectStatus = ArrayHelper::map(ProjectStatus::find()->all(), 'ProjectStatusID', 'ProjectStatusName');
		$ProjectStatusID = 0;
		$componentId = 0;
		$projectId = isset($params['FilterData']['ProjectID']) ? $params['FilterData']['ProjectID'] : 0;
		$countyId = isset($params['FilterData']['CountyID']) ? $params['FilterData']['CountyID'] : 0;
		
		if ($cid == 0) {
			$ProjectStatusID = isset($params['FilterData']['ProjectStatusID']) ? $params['FilterData']['ProjectStatusID'] : 0;
			$componentId = isset($params['FilterData']['ComponentID']) ? $params['FilterData']['ComponentID'] : 0;
			$where = [];
			if ($componentId != 0) {
				$where['ComponentID'] = $componentId;
			}
			if ($ProjectStatusID != 0) {
				$where['projects.ProjectStatusID'] = $ProjectStatusID;
			}

			if ($projectId != 0) {
				$where['projects.ProjectID'] = $projectId;
			}

			if ($countyId != 0) {
				$where['projects.CountyID'] = $countyId;
			}			

			$projects = Projects::find()->joinWith('projectStatus')->where($where)->all();
		} else {
			if (!empty($params) && isset($params['FilterData']['ProjectStatusID']) && $params['FilterData']['ProjectStatusID'] != 0) {
				$ProjectStatusID = $params['FilterData']['ProjectStatusID'];
				$projects = Projects::find()->joinWith('projectStatus')->where(['ComponentID' => $cid, 'projects.ProjectStatusID' => $ProjectStatusID])->all();
			} else {
				$projects = Projects::find()->joinWith('projectStatus')->where(['ComponentID' => $cid])->all();
			}
		}

		$pStatus = ProjectStatus::findOne($ProjectStatusID);

		$projectStatusName = !empty($pStatus) ? $pStatus->ProjectStatusName : '';

		if ($cid == 0) {
			$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		} else {
			$components = [];
		}

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('projects-finance', [
																				'projectStatus' => $projectStatus,
																				'projects' => $projects,
																				'projectStatusName' => $projectStatusName,
																			]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = $projectId;
		$model->ProjectStatusID = $ProjectStatusID;
		$model->ComponentID = $componentId;
		$model->CountyID = $countyId;
		$projects = ArrayHelper::map(Projects::find()->andWhere(['ComponentID' => $model->ComponentID])->all(), 'ProjectID', 'ProjectName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'months' => $months,
			'years' => $years,
			'model' => $model,
			'productcategories' => $productcategories,
			'Filter' => true,
			'CategoryFilterOnly' => true,
			'projectStatus' => $projectStatus,
			'projects' => $projects,
			'bankAccounts' => $bankAccounts,
			'components' => $components,
			'counties' => $counties,
			'report' => 'projects-finance',
		]);
	}

	public function actionProjectsFinanceEntities($cid)
	{
		$params = Yii::$app->request->post();
		$Title = 'Finance Report';

		$projectStatus = ArrayHelper::map(ProjectStatus::find()->all(), 'ProjectStatusID', 'ProjectStatusName');
		$ProjectStatusID = 0;
		$componentId = 0;
		
		if ($cid == 0) {
			$ProjectStatusID = isset($params['FilterData']['ProjectStatusID']) ? $params['FilterData']['ProjectStatusID'] : 0;
			$componentId = isset($params['FilterData']['ComponentID']) ? $params['FilterData']['ComponentID'] : 0;
			$where = [];
			if ($componentId != 0) {
				$where['ComponentID'] = $componentId;
			}
			if ($ProjectStatusID != 0) {
				$where['projects.ProjectStatusID'] = $ProjectStatusID;
			}
			$projects = Projects::find()->joinWith('projectStatus')->where($where)->all();
		} else {
			if (!empty($params) && isset($params['FilterData']['ProjectStatusID']) && $params['FilterData']['ProjectStatusID'] != 0) {
				$ProjectStatusID = $params['FilterData']['ProjectStatusID'];
				$projects = Projects::find()->joinWith('projectStatus')
														->where(['ComponentID' => $cid, 'projects.ProjectStatusID' => $ProjectStatusID])->all();
			} else {
				$projects = Projects::find()->joinWith('projectStatus')
														->where(['ComponentID' => $cid])->all();
			}
		}

		$pStatus = ProjectStatus::findOne($ProjectStatusID);

		$projectStatusName = !empty($pStatus) ? $pStatus->ProjectStatusName : '';

		if ($cid == 0) {
			$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		} else {
			$components = [];
		}

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('projects-finance-entities', [
																				'projectStatus' => $projectStatus,
																				'projects' => $projects,
																				'projectStatusName' => $projectStatusName,
																			]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = 0;
		$model->ProjectStatusID = $ProjectStatusID;
		$model->ComponentID = $componentId;
		//$pdf->Output('test.pdf', 'F');
		$projects = [];
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true,
			'projectStatus' => $projectStatus,
			'projects' => $projects,
			'bankAccounts' => $bankAccounts,
			'components' => $components,
		]);
	}

	public function actionProjectsCummulativeExpenditure($cid)
	{
		$params = Yii::$app->request->post();
		$Title = 'Project Cummulative Expenditure';
		$startDate = date('Y') . '-01-01';
		$endDate = date('Y-m-d');
		$componentId = 0;

		if (Yii::$app->request->post()) {
			$startDate = isset($params['FilterData']['StartDate']) ? $params['FilterData']['StartDate'] : date('Y') . '-01-01';
			$endDate = isset($params['FilterData']['EndDate']) ? $params['FilterData']['EndDate'] : date('Y-m-d');
			$componentId = isset($params['FilterData']['ComponentID']) ? $params['FilterData']['ComponentID'] : 0;
		}

		$projectStatus = ArrayHelper::map(ProjectStatus::find()->all(), 'ProjectStatusID', 'ProjectStatusName');
		$ProjectStatusID = 0;
		$componentId = 0;
		
		if ($cid == 0) {
			$ProjectStatusID = isset($params['FilterData']['ProjectStatusID']) ? $params['FilterData']['ProjectStatusID'] : 0;
			$componentId = isset($params['FilterData']['ComponentID']) ? $params['FilterData']['ComponentID'] : 0;
			$where = [];
			if ($componentId != 0) {
				$where['ComponentID'] = $componentId;
			}
			if ($ProjectStatusID != 0) {
				$where['projects.ProjectStatusID'] = $ProjectStatusID;
			}
			// print_r($where); exit;
			$projects = Projects::find()->joinWith('projectStatus')->where($where)->all();
		} else {
			if (!empty($params) && isset($params['FilterData']['ProjectStatusID']) && $params['FilterData']['ProjectStatusID'] != 0) {
				$ProjectStatusID = $params['FilterData']['ProjectStatusID'];
				$projects = Projects::find()->joinWith('projectStatus')
													->where(['ComponentID' => $cid, 'projects.ProjectStatusID' => $ProjectStatusID])
													->all();
			} else {
				$projects = Projects::find()->joinWith('projectStatus')->where(['ComponentID' => $cid])->all();
			}
		}

		$pStatus = ProjectStatus::findOne($ProjectStatusID);
		$projectStatusName = !empty($pStatus) ? $pStatus->ProjectStatusName : 'All';
		$comp = Components::findOne($componentId);
		$componentName = !empty($comp) ? $comp->ComponentName : 'All';

		if ($cid == 0) {
			$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		} else {
			$components = [];
		}



		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('projects-cummulative-expenditure', [
																				'projectStatus' => $projectStatus,
																				'projects' => $projects,
																				'projectStatusName' => $projectStatusName,
																				'componentName' => $componentName,
																				'startDate' => $startDate,
																				'endDate' => $endDate,
																			]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = 0;
		$model->ProjectStatusID = $ProjectStatusID;
		$model->ComponentID = $componentId;
		$model->StartDate = $startDate;
		$model->EndDate = $endDate;

		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model,
			'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true,
			'projectStatus' => $projectStatus,
			'projects' => [],
			'bankAccounts' => $bankAccounts,
			'components' => $components,
			'report' => 'projects-cummulative-expenditure'
		]);
	}

	public function actionMonthlyFinanceReport($pid = 0)
	{
		$params = Yii::$app->request->post();
		$Year = date('Y');
		$Month = (integer) date('m');

		$ProjectID = isset($params['FilterData']['ProjectID']) ? $params['FilterData']['ProjectID'] : $pid;
		$Month = isset($params['FilterData']['Month']) ? $params['FilterData']['Month'] : (integer) date('m');
		$Year = isset($params['FilterData']['Year']) ? $params['FilterData']['Year'] : date('Y');

		$months = [1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.'];
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) {
			$years[$x] = $x;
		}

		$Title = 'Monthly Finance Report';

		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');

		$projectData = Projects::find()->joinWith('components')
												->where(['ProjectID' => $ProjectID])
												->one();
		$fundsRequisition = FundsRequisition::find()->where(['ProjectID' => $ProjectID])
												->andWhere("MONTH(Date) = $Month AND YEAR(Date) = $Year")
												->all();
		$payments = Payments::find()->joinWith('invoices')
												->joinWith('invoices.purchases')
												->where(['purchases.ProjectID' => $ProjectID])
												->andWhere("MONTH(Date) = $Month AND YEAR(Date) = $Year")
												->all();
		$totalReceipts = FundsRequisition::find()->where(['ProjectID' => $ProjectID])
												->andWhere("MONTH(Date) = $Month AND YEAR(Date) = $Year")
												->sum('Amount');
		$totalPayments = Payments::find()->joinWith('invoices')
													->joinWith('invoices.purchases')
													->where(['purchases.ProjectID' => $ProjectID])
													->andWhere("MONTH(Date) = $Month AND YEAR(Date) = $Year")
													->sum('payments.Amount');

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('monthly-finance-report', [
																				'projectData' => $projectData,
																				'projects' => $projects,
																				'Month' => $months[(string) $Month],
																				'Year' => $Year,
																				'fundsRequisition' => $fundsRequisition,
																				'payments' => $payments,
																				'totalReceipts' => $totalReceipts,
																				'totalPayments' => $totalPayments,
																			]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = $ProjectID;
		$model->Month = $Month;
		$model->Year = $Year;
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true, 'projects' => $projects,
			'bankAccounts' => $bankAccounts, 'SupplierFilter' => false, 'CategoryFilterOnly' => false,
		]);
	}

	public function actionWorkPlan($cid)
	{
		$params = Yii::$app->request->post();
		$projectsModel = Projects::find()->where(['ComponentID' => $cid])->all();
		$projects = ArrayHelper::map($projectsModel, 'ProjectID', 'ProjectName');

		$ProjectID = 1;
		if (!empty($params) && isset($params['FilterData']['ProjectID'])) {
			$ProjectID = $params['FilterData']['ProjectID'];
		} else {
			$ProjectID = (!empty($projectsModel)) ? $projectsModel[0]->ProjectID : 0;
		}
		
		$Title = 'Work Plan';
		$activities = Activities::find()->joinWith('indicators')
													->joinWith('employees')
													->joinWith('activityBudget')
													->joinWith('activityOutputs')
													->where(['indicators.ProjectID' => $ProjectID])
													->asArray()
													->orderBy('indicators.IndicatorID')
													->all();
/* 		print('<pre>');
		print_r($activities); exit; */
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('work-plan', [
																			'activities' => $activities,
																			'project' => Projects::findOne($ProjectID),
																		]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = 1;
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true, 'projects' => $projects,
			'bankAccounts' => $bankAccounts
		]);
	}

	public function actionBudget($cid)
	{
		$params = Yii::$app->request->post();
		$projectsModel = Projects::find()->where(['ComponentID' => $cid])->all();
		$projects = ArrayHelper::map($projectsModel, 'ProjectID', 'ProjectName');

		if (!empty($params) && isset($params['FilterData']['ProjectID'])) {
			$ProjectID = $params['FilterData']['ProjectID'];
		} else {
			$ProjectID = (!empty($projectsModel)) ? $projectsModel[0]->ProjectID : 0;
		}
		
		$Title = 'Budget';
		$budgetProvider = new ActiveDataProvider([
			'query' => ActivityBudget::find()->joinWith('activities')
													->joinWith('activities.indicators')
													->where(['ProjectID' => $ProjectID])
													->asArray()
													->orderBy('activities.ActivityID'),
			// 'sort'=> ['defaultOrder' => ['activities.ActivityID'=>SORT_DESC]],
		]);

		// $model = ActivityBudget::find()->joinWith('activities')
		// ->joinWith('activities.indicators')
		// ->where(['ProjectID' => $ProjectID])
		// ->orderBy('activities.ActivityID')->asArray()->all();
		// print('<pre>');
		// print_r($model); exit;

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('budget', [
																	'budgetProvider' => $budgetProvider,
																	'project' => Projects::findOne($ProjectID),
																]);
		
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
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = 1;
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true, 'projects' => $projects,
			'bankAccounts' => $bankAccounts
		]);
	}

	public function actionProcurementPlan($id)
	{
		$params = Yii::$app->request->post();
		$cid = 0;
		$projectsModel = $cid == 0 ? Projects::find()->all() : Projects::find()->where(['ComponentID' => $cid])->all();
		$projects = ArrayHelper::map($projectsModel, 'ProjectID', 'ProjectName');

		if (!empty($params) && isset($params['FilterData']['ProjectID'])) {
			$ProjectID = $params['FilterData']['ProjectID'];
		} else {
			$ProjectID = (!empty($projectsModel)) ? $projectsModel[0]->ProjectID : 0;
		}
		// echo $ProjectID; exit;
		
		$Title = 'Procurement Plan';
		/* $budgetProvider = new ActiveDataProvider([
			'query' => ActivityBudget::find()->joinWith('activities')
													->joinWith('activities.indicators')
													->where(['ProjectID' => $ProjectID, 'activities.ProcurementItem' => 1])
													->orderBy('activities.ActivityID'),
		]); */

		$procurementPlan = ProcurementPlanLines::find()
			->joinWith('procurementActivityLines')
			->joinWith('unitsOfMeasure')
			->joinWith('procurementMethods')
			->andWhere(['ProcurementPlanID' => $id])->all();

		$activities = procurementActivityLines::find()
			->joinWith('procurementPlanLines')
			->andWhere(['ProcurementPlanID' => $id])
			->select('*, DATEDIFF(`ActualClosingDate`, `ActualStartDate`) as ActualDays')
			->asArray()
			->all();

		$activities = ArrayHelper::index($activities, 'ProcurementActivityID', [function ($element) {
			return $element['ProcurementPlanLineID'];
	  }]);

	//   print('<pre>');
	//   print_r($activities); exit;

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('procurement-plan', [
																	'procurementPlan' => $procurementPlan,
																	'activities' => $activities,
																	'project' => Projects::findOne($ProjectID),
																]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf-small.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		// return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		$months = [];
		$years = [];
		$productcategories = [];
		$bankAccounts = [];
		$model = new FilterData();
		$model->ProjectID = $ProjectID;
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content, 'months' => $months, 'years' => $years,
			'model' => $model, 'productcategories' => $productcategories, 'Filter' => true,
			'CategoryFilterOnly' => true, 'projects' => $projects,
			'bankAccounts' => $bankAccounts
		]);
	}

	public function actionComponent1Report()
	{
		$params = Yii::$app->request->post();
		$model = new FilterData();
		$model->StartDate = date('Y') . '-01-01';
		$model->EndDate = date('Y-m-d');

		$model->CountyID = 0;
		$model->SubCountyID = 0;
		$model->LocationID = 0;
		$model->SubLocationID = 0;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			// Validate something
		}
		
		$Title = 'Component 1 Finance Reports';

		// $m = Projects::find()->joinWith('projectSectors')->joinWith('subComponents')->asArray()->all();
		$sql = 'SELECT `subcomponents`.`SubComponentID`, `projectsectors`.`ProjectSectorID`, sum(activitybudget.Amount) AS `BudgetAmount` FROM `activitybudget` 
					LEFT JOIN `activities` ON `activitybudget`.`ActivityID` = `activities`.`ActivityID` 
					LEFT JOIN `indicators` ON `activities`.`IndicatorID` = `indicators`.`IndicatorID` 
					LEFT JOIN `projects` ON `indicators`.`ProjectID` = `projects`.`ProjectID` 
					LEFT JOIN `subcomponents` ON `subcomponents`.`SubComponentID` = `projects`.`SubComponentID` 
					LEFT JOIN `projectsectors` ON `projectsectors`.`ProjectSectorID` = `projects`.`ProjectSectorID` 
					WHERE `projects`.`ComponentID`=1
					GROUP BY `subcomponents`.`SubComponentID`, `projectsectors`.`ProjectSectorID`';
		$budget = ActivityBudget::findBySql($sql)->asArray()->all();
		  
		$budget = ArrayHelper::index($budget, function ($element) {
			return $element['ProjectSectorID'];
		}, 'SubComponentID');

		$sql = 'SELECT `subcomponents`.`SubComponentID`, `projectsectors`.`ProjectSectorID`, SUM(payments.Amount) as AmountSpent FROM `payments` 
					LEFT JOIN `invoices` ON `payments`.`InvoiceID` = `invoices`.`InvoiceID` 
					LEFT JOIN `purchases` ON `invoices`.`PurchaseID` = `purchases`.`PurchaseID` 
					LEFT JOIN `projects` ON `purchases`.`ProjectID` = `projects`.`ProjectID` 
					LEFT JOIN `subcomponents` ON `subcomponents`.`SubComponentID` = `projects`.`SubComponentID` 
					LEFT JOIN `projectsectors` ON `projectsectors`.`ProjectSectorID` = `projects`.`ProjectSectorID` 
					WHERE `projects`.`ComponentID`=1
					GROUP BY `subcomponents`.`SubComponentID`, `projectsectors`.`ProjectSectorID`';
		$expenditure = Payments::findBySql($sql)->asArray()->all();

		$expenditure = ArrayHelper::index($expenditure, function ($element) {
			return $element['ProjectSectorID'];
		}, 'SubComponentID');

		$subComponents = \app\models\SubComponents::find()->andWhere(['ComponentID' => 1])->all();
		$sectors = ProjectSectors::find()->all();
		$component = Components::findOne(1);

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('component1-report', [
			'component' => $component,
			'subComponents' => $subComponents,
			'sectors' => $sectors,
			'budget' => $budget,
			'expenditure' => $expenditure,
		]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);

		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->andWhere(['CountyID' => $model->CountyID])->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->andWhere(['SubCountyID' => $model->SubCountyID])->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->andWhere(['LocationID' => $model->LocationID])->orderBy('SubLocationName')->all(), 'SubLocationID', 'SubLocationName');

		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'model' => $model,
			'report' => 'component1-report',
			'Filter' => true,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	public function actionComponent2Report()
	{
		$params = Yii::$app->request->post();
		$model = new FilterData();
		$model->StartDate = date('Y') . '-01-01';
		$model->EndDate = date('Y-m-d');

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			// Validate something
		}
		
		$Title = 'Component 2 Finance Reports';

		// $m = Projects::find()->joinWith('projectSectors')->joinWith('subComponents')->asArray()->all();
		$sql = 'SELECT `subcomponents`.`SubComponentID`, `sub_component_categories`.`SubComponentCategoryID`, sum(activitybudget.Amount) AS `BudgetAmount` FROM `activitybudget` 
					LEFT JOIN `activities` ON `activitybudget`.`ActivityID` = `activities`.`ActivityID` 
					LEFT JOIN `indicators` ON `activities`.`IndicatorID` = `indicators`.`IndicatorID` 
					LEFT JOIN `projects` ON `indicators`.`ProjectID` = `projects`.`ProjectID` 
					LEFT JOIN `subcomponents` ON `subcomponents`.`SubComponentID` = `projects`.`SubComponentID` 
					LEFT JOIN `sub_component_categories` ON `sub_component_categories`.`SubComponentCategoryID` = `projects`.`SubComponentCategoryID`
					WHERE `projects`.`ComponentID` = 2
					GROUP BY `subcomponents`.`SubComponentID`, `sub_component_categories`.`SubComponentCategoryID`';
		$budget = ActivityBudget::findBySql($sql)->asArray()->all();
		  
		$budget = ArrayHelper::index($budget, function ($element) {
			return $element['SubComponentCategoryID'];
		}, 'SubComponentID');

		$sql = 'SELECT `subcomponents`.`SubComponentID`, `sub_component_categories`.`SubComponentCategoryID`, SUM(payments.Amount) as AmountSpent FROM `payments` 
					LEFT JOIN `invoices` ON `payments`.`InvoiceID` = `invoices`.`InvoiceID` 
					LEFT JOIN `purchases` ON `invoices`.`PurchaseID` = `purchases`.`PurchaseID` 
					LEFT JOIN `projects` ON `purchases`.`ProjectID` = `projects`.`ProjectID` 
					LEFT JOIN `subcomponents` ON `subcomponents`.`SubComponentID` = `projects`.`SubComponentID` 
					LEFT JOIN `sub_component_categories` ON `sub_component_categories`.`SubComponentCategoryID` = `projects`.`SubComponentCategoryID` 
					WHERE `projects`.`ComponentID` = 2
					GROUP BY `subcomponents`.`SubComponentID`, `sub_component_categories`.`SubComponentCategoryID`';
		$expenditure = Payments::findBySql($sql)->asArray()->all();

		$expenditure = ArrayHelper::index($expenditure, function ($element) {
			return $element['SubComponentCategoryID'];
		}, 'SubComponentID');

		$subComponents = \app\models\SubComponents::find()->andWhere(['ComponentID' => 2])->all();
		$categories = SubComponentCategories::find()->all();
		$component = Components::findOne(2);

		// print('<pre>');
		// print_r($budget); exit;

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('component2-report', [
			'component' => $component,
			'subComponents' => $subComponents,
			'categories' => $categories,
			'budget' => $budget,
			'expenditure' => $expenditure,
		]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);

		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->andWhere(['CountyID' => $model->CountyID])->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->andWhere(['SubCountyID' => $model->SubCountyID])->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->andWhere(['LocationID' => $model->LocationID])->orderBy('SubLocationName')->all(), 'SubLocationID', 'SubLocationName');
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'model' => $model,
			'report' => 'component2-report',
			'Filter' => true,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	public function actionComponent3Report()
	{
		$params = Yii::$app->request->post();
		$model = new FilterData();
		$model->StartDate = date('Y') . '-01-01';
		$model->EndDate = date('Y-m-d');

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			// Validate something
		}
		
		$Title = 'Component 3 Finance Reports';

		$sql = 'SELECT `subcomponents`.`SubComponentID`, `enterprisetypes`.`EnterpriseTypeID`, sum(activitybudget.Amount) AS `BudgetAmount` FROM `activitybudget` 
					LEFT JOIN `activities` ON `activitybudget`.`ActivityID` = `activities`.`ActivityID` 
					LEFT JOIN `indicators` ON `activities`.`IndicatorID` = `indicators`.`IndicatorID` 
					LEFT JOIN `projects` ON `indicators`.`ProjectID` = `projects`.`ProjectID` 
					LEFT JOIN `subcomponents` ON `subcomponents`.`SubComponentID` = `projects`.`SubComponentID` 
					LEFT JOIN `enterprisetypes` ON `enterprisetypes`.`EnterpriseTypeID` = `projects`.`EnterpriseTypeID` 
					WHERE `projects`.`ComponentID` = 3
					GROUP BY `subcomponents`.`SubComponentID`, `enterprisetypes`.`EnterpriseTypeID`';
		$budget = ActivityBudget::findBySql($sql)->asArray()->all();
		  
		$budget = ArrayHelper::index($budget, function ($element) {
			return $element['EnterpriseTypeID'];
		}, 'SubComponentID');

		$sql = 'SELECT `subcomponents`.`SubComponentID`, `enterprisetypes`.`EnterpriseTypeID`, SUM(payments.Amount) as AmountSpent FROM `payments` 
					LEFT JOIN `invoices` ON `payments`.`InvoiceID` = `invoices`.`InvoiceID` 
					LEFT JOIN `purchases` ON `invoices`.`PurchaseID` = `purchases`.`PurchaseID` 
					LEFT JOIN `projects` ON `purchases`.`ProjectID` = `projects`.`ProjectID` 
					LEFT JOIN `subcomponents` ON `subcomponents`.`SubComponentID` = `projects`.`SubComponentID` 
					LEFT JOIN `enterprisetypes` ON `enterprisetypes`.`EnterpriseTypeID` = `projects`.`EnterpriseTypeID` 
					WHERE `projects`.`ComponentID` = 3
					GROUP BY `subcomponents`.`SubComponentID`, `enterprisetypes`.`EnterpriseTypeID`';
		$expenditure = Payments::findBySql($sql)->asArray()->all();

		$expenditure = ArrayHelper::index($expenditure, function ($element) {
			return $element['EnterpriseTypeID'];
		}, 'SubComponentID');

		$subComponents = \app\models\SubComponents::find()->andWhere(['ComponentID' => 3])->all();
		$enterpriseTypes = EnterpriseTypes::find()->all();
		$component = Components::findOne(3);

		// print('<pre>');
		// print_r($budget); exit;

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('component3-report', [
			'component' => $component,
			'subComponents' => $subComponents,
			'enterpriseTypes' => $enterpriseTypes,
			'budget' => $budget,
			'expenditure' => $expenditure,
		]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);

		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->andWhere(['CountyID' => $model->CountyID])->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->andWhere(['SubCountyID' => $model->SubCountyID])->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->andWhere(['LocationID' => $model->LocationID])->orderBy('SubLocationName')->all(), 'SubLocationID', 'SubLocationName');
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'model' => $model,
			'report' => 'component3-report',
			'Filter' => true,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'subLocations' => $subLocations,
		]);
	}

	public function actionComponentFinanceReport()
	{
		$params = Yii::$app->request->post();
		$model = new FilterData();
		$model->StartDate = date('Y') . '-01-01';
		$model->EndDate = date('Y-m-d');

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			// Validate something
			$params = Yii::$app->request->post()['FilterData'];
			$countyId = isset($params['CountyID']) ? $params['CountyID'] : 0;
			$componentId = isset($params['ComponentID']) ? $params['ComponentID'] : 0;
		}
		
		$Title = 'Component Finance Reports';

		$dataProvider = new ActiveDataProvider([
			'query' => Components::find(),
			'pagination' => false,
		]);

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('component-finance-report', ['dataProvider' => $dataProvider]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'model' => $model,
			'report' => 'component-finance-report',
			'Filter' => true,
		]);
	}

	public function actionImplementationStatusReport()
	{
		$params = Yii::$app->request->post();
		$model = new FilterData();
		$model->StartDate = date('Y') . '-01-01';
		$model->EndDate = date('Y-m-d');

		$countyId = 0;
		$componentId = 0;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			// Validate something
			$params = Yii::$app->request->post()['FilterData'];
			$countyId = isset($params['CountyID']) ? $params['CountyID'] : 0;
			$componentId = isset($params['ComponentID']) ? $params['ComponentID'] : 0;
		}

		$where = '1=1';
		$where .= ($countyId != 0) ? " AND CountyID = $countyId " : '';
		$where .= ($componentId != 0) ? " AND ComponentID = $componentId " : '';
		
		$Title = 'KDRDIP Tool for Monitoring Implementation Status of the Approved Work Plans';

		$dataProvider = new ActiveDataProvider([
			'query' => Projects::find()->andWhere($where),
			'pagination' => false,
		]);

		/* 
			Project Statuses
		*/
		$statusProvider = new ActiveDataProvider([
			'query' => ProjectStatus::find()->andWhere('ProjectStatusID > 1'),
			'pagination' => false,
		]);

		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('implementation-status', ['dataProvider' => $dataProvider, 'statusProvider' => $statusProvider]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf-small.css',
				// set mPDF properties on the fly
			'options' => ['title' => $Title],
				// call mPDF methods on the fly
			'methods' => [
				'SetHeader'=>[$Title],
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));

		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$components = ArrayHelper::map(Components::find()->orderBy('ComponentName')->all(), 'ComponentID', 'ComponentName');
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
			'model' => $model,
			'counties' => $counties,
			'components' => $components,
			'report' => 'implementation-status',
			'Filter' => true,
		]);
	}

	public function actionWriteExcel($model = [], $filename = 'Excel File')
	{
		return $this->writeExcel($model, $filename, []);
	}

	public static function writeExcel($model = [], $filename = 'Excel File', $diplayFields = [])
	{
		require_once 'PHPExcel/PHPExcel/IOFactory.php';
		$objPHPExcel = new \PHPExcel(); // Create new PHPExcel object
		$objPHPExcel->getProperties()->setCreator('M & E System')
		->setLastModifiedBy('M & E System')
		->setTitle('')
		->setSubject('')
		->setDescription('')
		->setKeywords('')
		->setCategory('');
		// create style
		$default_border = [
									'style' => \PHPExcel_Style_Border::BORDER_THIN,
									'color' => ['rgb' => '1006A3']
								];
		$style_header = [
								'borders' => [
													'bottom' => $default_border,
													'left' => $default_border,
													'top' => $default_border,
													'right' => $default_border,
												],
												'fill' => [
													'type' => \PHPExcel_Style_Fill::FILL_SOLID,
													'color' => ['rgb' => 'E1E0F7'],
												],
												'font' => [
													'bold' => true,
													'size' => 12,
												]
								];
		$style_content = [
			'borders' => [
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			],
			'fill' => [
				'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'eeeeee'],
			],
			'font' => [
				'size' => 12,
			]
			];

		// Create Header
		$firstRow = $model[0];
		$column = 'A';
		foreach ($firstRow as $key => $value) {
			if (in_array($key, $diplayFields)) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . '1', $key);
				// set Column Width
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(20);
				$column ++;
			}
		}
		$objPHPExcel->getActiveSheet()->getStyle('A1:' . $column . '1')->applyFromArray($style_header); // give style to header
		
		// Create Data
		$column = 'A';
		$firststyle='A2';
		$row = 2;
		foreach ($model as $rows) {
			$column = 'A';
			foreach ($rows as $key => $value) {
				if (in_array($key, $diplayFields)) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . (string) $row, $value);
					$column ++;
				}
			}
			$row ++;
		}
		$laststyle = $column . $row;
		$objPHPExcel->getActiveSheet()->getStyle($firststyle . ':' . $laststyle)->applyFromArray($style_content); // give style to header
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($filename);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $filename . '.xls'); // file name of excel
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}
