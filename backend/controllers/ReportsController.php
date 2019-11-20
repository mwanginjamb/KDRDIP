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
use app\models\purchaselines;
use app\models\Suppliers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * RequisitionController implements the CRUD actions for Requisition model.
 */
class ReportsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
		'access' => [
					'class' => AccessControl::className(),
					'only' => ['index', 'report', 'view', 'purchasesreport', 'inventoryreport', 'stocktakingreport'],
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
							'actions' => ['index', 'report', 'view', 'purchasesreport', 'inventoryreport', 'stocktakingreport'],
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
		$FilterString2 = "";
		if (!empty($params))
		{
			$Year = $params['FilterData']['Year'];
			$Month = $params['FilterData']['Month'];
			
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			$FilterString = "WHERE YEAR(PostingDate) = '".$params['FilterData']['Year']."'"; 
				
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0))
			{
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0))
			{
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Purchase Report';
		$sql = "SELECT * FROM (
				SELECT ProductID, Sum(Quantity) as Quantity, sum(Quantity * UnitPrice) as LineAmount FROM purchaselines
				JOIN Purchases ON Purchases.PurchaseID = purchaselines.PurchaseID
				$FilterString
				GROUP BY ProductID
				) temp 
				JOIN Product ON Product.ProductID = temp.ProductID
				JOIN ProductCategory ON ProductCategory.ProductCategoryID = Product.ProductCategoryID
				JOIN UsageUnit ON UsageUnit.UsageUnitID = Product.UsageUnitID
				$FilterString2
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		
		$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
		$FilterString2 = ""; 
		if (!empty($params))
		{
			//$Year = $params['FilterData']['Year'];
			//$Month = $params['FilterData']['Month'];
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			//$FilterString = "WHERE YEAR(PostingDate) = '".$params['FilterData']['Year']."'"; 
			
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0))
			{
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

					SELECT ProductID, sum(Quantity) as Quantity FROM StockAdjustment
					GROUP BY ProductID
					) as temp0 group by ProductID
				) as temp 
				JOIN Product ON Product.ProductID = temp.ProductID
				JOIN ProductCategory ON ProductCategory.ProductCategoryID = Product.ProductCategoryID
				JOIN UsageUnit ON UsageUnit.UsageUnitID = Product.UsageUnitID
				$FilterString2
				";
		//print_r($sql); exit;

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		//print_r( $products ); exit;
		$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
		$FilterString2 = ""; 
		if (!empty($params))
		{
			//$Year = $params['FilterData']['Year'];
			//$Month = $params['FilterData']['Month'];
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];			
			
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0))
			{
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0))
			{
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Stock Taking Sheets';
		$sql = "SELECT *, '' AS Qty FROM Product 
				JOIN ProductCategory ON ProductCategory.ProductCategoryID = Product.ProductCategoryID
				JOIN UsageUnit ON UsageUnit.UsageUnitID = Product.UsageUnitID
				$FilterString2
				ORDER BY ProductCategoryName, ProductName
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		//print_r( $products ); exit;
		$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
		if (!empty($params))
		{
			$StockTakeID = $params['FilterData']['StockTakeID'];			
		}
		$Title = 'Stock Variance Report';
		$sql = "SELECT * , PhysicalStock-CurrentStock as Variance FROM StockTakeLines
				LEFT JOIN Product ON Product.ProductID = StockTakeLines.ProductID
				LEFT JOIN ProductCategory ON ProductCategory.ProductCategoryID = Product.ProductCategoryID
				LEFT JOIN UsageUnit ON UsageUnit.UsageUnitID = Product.UsageUnitID
				WHERE StockTakeLines.StockTakeID = '$StockTakeID'
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => StockTakeLines::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$stocktake = ArrayHelper::map(StockTake::find()->all(), 'StockTakeID', 'Reason');
		
		//print_r($stocktake); Exit;
		$months = [];
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
		ini_set("memory_limit","512M");
		$params = Yii::$app->request->post();
		$SupplierID = 0;
		$wherestr = "WHERE ProductName is not Null ";
		if (!empty($params))
		{
			if (isset($params['FilterData']['SupplierID']) && $params['FilterData']['SupplierID'] != '')
			{
				$SupplierID = $params['FilterData']['SupplierID'];
				$wherestr = " AND Purchases.SupplierID = '$SupplierID' AND ProductName is not Null";
			} 
		} 
		
		$Title = 'Stock Variance Report';
		$sql = "SELECT *, purchaselines.UnitPrice * Quantity as Total  FROM purchaselines
				LEFT JOIN Purchases ON Purchases.PurchaseID = purchaselines.PurchaseID
				LEFT JOIN Product ON Product.ProductID = purchaselines.ProductID
				LEFT JOIN ProductCategory ON ProductCategory.ProductCategoryID = Product.ProductCategoryID
				$wherestr
				ORDER BY ProductCategoryName
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => purchaselines::findBySql($sql)->asArray()->all(), 'pagination' => false,
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
		$FilterString2 = "";
		if (!empty($params))
		{
			$Year = $params['FilterData']['Year'];
			$Month = $params['FilterData']['Month'];
			
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];
			
			$FilterString = "WHERE YEAR(PostingDate) = '".$params['FilterData']['Year']."'"; 
				
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0))
			{
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0))
			{
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
			}
		}
		$Title = 'Supplier Balances';
		$sql = "SELECT sum(Amount) as Amount, Temp.SupplierID, SupplierName FROM 
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
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Suppliers::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		
		$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
		$FilterString2 = "";
		$SupplierID = 0;
		if (!empty($params))
		{
			$Year = isset($params['FilterData']['Year']) ? $params['FilterData']['Year'] : $Year = date('Y');
			$Month = isset($params['FilterData']['Month']) ? $params['FilterData']['Month'] : $Month = date('m');;
			
			$ProductCategoryID = isset($params['FilterData']['ProductCategoryID']) ? $params['FilterData']['ProductCategoryID'] : 0;
			
			$SupplierID = isset($params['FilterData']['SupplierID']) ? $params['FilterData']['SupplierID'] : 0;
			
			$FilterString = "WHERE YEAR(PostingDate) = '$Year'";
				
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0))
			{
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0))
			{
				$FilterString .= ' AND MONTH(PostingDate) = ' . $params['FilterData']['Month'];
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
				WHERE SupplierID = $SupplierID
				ORDER BY CreatedDate Desc
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Purchases::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');		
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		
		$supplier = Suppliers::findOne($SupplierID);
		
		$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
			'SupplierFilter' => true,
			]);
	}	

	public function actionStockreport()
	{
		$params = Yii::$app->request->post();
		$FilterString = '';
		$Year = date('Y');
		$Month = date('m');
		$ProductCategoryID = 0;
		$FilterString2 = ""; 
		if (!empty($params))
		{
			//$Year = $params['FilterData']['Year'];
			//$Month = $params['FilterData']['Month'];
			$ProductCategoryID = $params['FilterData']['ProductCategoryID'];			
			
			if ((isset($params['FilterData']['ProductCategoryID'])) && ($params['FilterData']['ProductCategoryID']!=0))
			{
				$FilterString2 .= ' WHERE Product.ProductCategoryID = ' . $params['FilterData']['ProductCategoryID'];
			}
			
			if ((isset($params['FilterData']['Month'])) && ($params['FilterData']['Month']!=0))
			{
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
						SELECT ProductID, 0 as Ordered, sum(Quantity) as Issued FROM RequisitionLine
						WHERE ProductID is not Null
						GROUP BY ProductID
						)
					) as Temp
					JOIN Product ON Product.ProductID = Temp.ProductID
					JOIN ProductCategory ON ProductCategory.ProductCategoryID = Product.ProductCategoryID
					$FilterString2
					GROUP BY ProductCategoryName, ProductName,Temp.ProductID
				";

		$dataProvider = new ArrayDataProvider([
				'allModels' => Product::findBySql($sql)->asArray()->all(), 'pagination' => false,
			]);
		$productcategories = ArrayHelper::map(ProductCategory::find()->all(), 'ProductCategoryID', 'ProductCategoryName');
		//print_r( $products ); exit;
		$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
		//print_r( $months ); exit;
		$years= [];
		for ($x = 2017; $x <= date('Y'); $x++) 
		{
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
}
