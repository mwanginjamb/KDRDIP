<?php

namespace backend\controllers;

use Yii;
use app\models\Purchases;
use app\models\Suppliers;
use app\models\PriceList;
use app\models\Quotation;
use app\models\Company;
use app\models\PurchaseLines;
use app\models\UserCategory;
use app\models\SupplierCategory;
use app\models\ApprovalNotes;
use app\models\Product;
use app\models\UsageUnit;
use app\models\Projects;
use app\models\QuotationResponseLines;
use app\models\QuotationProducts;
use app\models\QuotationSupplier;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\controllers\UsersController;

use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * PurchasesController implements the CRUD actions for Purchases model.
 */
class PurchasesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(39);

		$rightsArray = []; 
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view', 'submit', 'purchaseorder');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create', 'submit', 'purchaseorder');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update', 'submit', 'purchaseorder');
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
			'only' => ['index', 'view', 'create', 'update', 'delete',  'submit', 'purchaseorder'],
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
	 * Lists all Purchases models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$UserID = Yii::$app->user->identity->UserID;
		
		$dataProvider = new ActiveDataProvider([
			'query' => Purchases::find()->joinWith('suppliers')->joinWith('approvalstatus'),
												// ->where(['purchases.CreatedBy' => $UserID]),
			'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	public function actionApproved()
	{
		$UserID = Yii::$app->user->identity->UserID;
		
		$dataProvider = new ActiveDataProvider([
			'query' => Purchases::find()->joinWith('suppliers')->joinWith('approvalstatus')->where(['Purchases.ApprovalStatusID' => 3]),
			'sort'=> ['defaultOrder' => ['PostingDate'=>SORT_DESC]],
		]);

		return $this->render('Approved', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Purchases model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$notes = new ActiveDataProvider([
				'query' => ApprovalNotes::find()->where(['ApprovalTypeID'=>2, 'ApprovalID' => $id]),
			]);
		
		$dataProvider = new ActiveDataProvider([
				'query' => PurchaseLines::find()->joinWith('product')
											->where(['PurchaseID'=> $id]),
			]);
		$model = Purchases::find()->where(['PurchaseID'=> $id])
								->joinWith('approvalstatus')->joinWith('suppliers')
								->joinWith('users')
								->one();

		return $this->render('view', [
			'model' => $model, 'dataProvider' => $dataProvider, 'notes' => $notes,
			'rights' => $this->rights,
		]);
	}

	public function actionViewapproved($id)
	{
		$notes = new ActiveDataProvider([
				'query' => ApprovalNotes::find()->where(['ApprovalTypeID'=>2, 'ApprovalID' => $id]),
			]);
		
		$dataProvider = new ActiveDataProvider([
				'query' => PurchaseLines::find()->joinWith('product')
											->where(['PurchaseID'=> $id]),
			]);
		$model = Purchases::find()->where(['PurchaseID'=> $id])
								->joinWith('approvalstatus')->joinWith('suppliers')
								->joinWith('users')
								->one();
		return $this->render('viewapproved', [
			'model' => $model, 'dataProvider' => $dataProvider, 'notes' => $notes,
			'rights' => $this->rights,
		]);
	}	

	/**
	 * Creates a new Purchases model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;

		$model = new Purchases();
		$model->CreatedBy = $UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$PurchaseID = $model->PurchaseID;

			$quotationLines = QuotationResponseLines::find()->joinWith('quotationResponse')
										->joinWith('quotationProducts')
										->where(['quotationresponse.SupplierID' => $model->SupplierID,
													'quotationresponse.QuotationID' => $model->QuotationID])
										->all();
			// print_r($quotationLines); exit;
			foreach ($quotationLines as $line) {
				$purchaseLines = new PurchaseLines();

				$purchaseLines->PurchaseID = $model->PurchaseID;
				$purchaseLines->ProductID = $line->quotationProducts->ProductID;
				$purchaseLines->Quantity = $line->quotationProducts->Quantity; 
				$purchaseLines->UnitPrice = $line->UnitPrice;
				$purchaseLines->UsageUnitID = $line->quotationProducts->product->UsageUnitID;
				if (!$purchaseLines->save()) {
					// print_r($purchaseLines->getErrors()); exit;
				}
				// SupplierCode = '';
			}
			
		/* 	$params = Yii::$app->request->post();
			$lines = isset($params['PurchaseLines']) ? $params['PurchaseLines'] : [];
			
			foreach ($lines as $key => $line)
			{
				//print_r($lines);exit;
					
				if ($line['ProductID'] != '') {
					$_line = new PurchaseLines();
					$_line->PurchaseID = $PurchaseID;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->UnitPrice = $line['UnitPrice'];
					$_line->save();
					//print_r($_line->getErrors());
				}
			}
			//exit; */
			return $this->redirect(['view', 'id' => $model->PurchaseID]);
		} 

		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$suppliers = []; // ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$pricelist = ArrayHelper::map(PriceList::find()->all(), 'SupplierCode', 'ProductName');
		$usageunits = ArrayHelper::map(UsageUnit::find()->all(), 'UsageUnitID', 'UsageUnitName');
		$quotations = []; //ArrayHelper::map(Quotation::find()->orderBy('QuotationID DESC')->all(), 'QuotationID', 'Description');
		for ($x = 0; $x <= 19; $x++) {
			$lines[$x] = new PurchaseLines();
		}
		return $this->render('create', [
			'model' => $model, 'suppliers' => $suppliers, 'lines' => $lines,
			'products' => $products, 'pricelist' => $pricelist, 'usageunits' => $usageunits,
			'quotations' => $quotations,
			'rights' => $this->rights,
			'projects' => $projects,
		]);		
	}

	/**
	 * Updates an existing Purchases model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
	
		$model = $this->findModel($id);
		$lines = PurchaseLines::find()->where(['PurchaseID' => $id])->all();
	
		if ($model->load(Yii::$app->request->post()) ) {
			// print '<pre>';
			// print_r(Yii::$app->request->post()); exit;
			// if (!$model->save()) {
			// 	print_r($model->getErrors()); exit;
			// }
			$params = Yii::$app->request->post();
			$lines = $params['PurchaseLines'];

			// print_r($lines); exit;
			
			foreach ($lines as $key => $line) {
				$unitprice = $this->Getunitprice($model->SupplierID, $line['ProductID'], $line['SupplierCode']);
				if ($line['PurchaseLineID'] == '') {
					if ($line['ProductID'] != '') {
						$_line = new PurchaseLines();
						$_line->PurchaseID = $id;
						$_line->ProductID = $line['ProductID'];
						$_line->UsageUnitID = $line['UsageUnitID'];
						$_line->Quantity = $line['Quantity'];
						$_line->UnitPrice = $unitprice; //str_replace(',', '', $line['UnitPrice']);
						$_line->SupplierCode = $line['SupplierCode'];
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else {
					$_line = PurchaseLines::findOne($line['PurchaseLineID']);
					$_line->PurchaseID = $id;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->UsageUnitID = $line['UsageUnitID'];
					$_line->SupplierCode = $line['SupplierCode'];
					$_line->UnitPrice = str_replace(',', '', $line['UnitPrice']);
					$_line->save();
				}
			}
		
			return $this->redirect(['view', 'id' => $model->PurchaseID]);
		}
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$suppliers = ArrayHelper::map(QuotationSupplier::find()->joinWith('suppliers')->where(['QuotationID' => $model->QuotationID])->asArray()->all(), 'suppliers.SupplierID', 'suppliers.SupplierName');
		$usageunits = ArrayHelper::map(UsageUnit::find()->all(), 'UsageUnitID', 'UsageUnitName');
		$usercategories = ArrayHelper::getColumn(UserCategory::find()->where(['UserID' => $UserID, 'Selected' => 1])->all(),'ProductCategoryID');
		$quotations = ArrayHelper::map(Quotation::find()->where(['ProjectID' => $model->ProjectID])->all(), 'QuotationID', 'Description');
		$scategory = ArrayHelper::getColumn(SupplierCategory::find()->where(['SupplierID' => $model->SupplierID, 'Selected' => 1])->all(),'ProductCategoryID');
		// print_r($suppliers); exit;
		$suppliercategory = array(0);
		foreach ($scategory as $key => $value) {
			// if (in_array($value, $usercategories)) {
				$suppliercategory[] = $value;
			// }
		}

		$quotationProducts = ArrayHelper::getColumn(QuotationProducts::find()->where(['QuotationID' => $model->QuotationID])->all(),'ProductID');

		$products = ArrayHelper::map(Product::find()->where("(ProductCategoryID IN (".implode(",",$suppliercategory).")
																OR ProductCategory2ID IN (".implode(",",$suppliercategory).")
																OR ProductCategory3ID IN (".implode(",",$suppliercategory)."))
																AND ProductID IN (" . implode(",",$quotationProducts) . ")")
													->all(), 'ProductID', 'ProductName');
		$pricelist = ArrayHelper::map(PriceList::find()->where(['SupplierID' => $model->SupplierID])->all(), 'SupplierCode', 'ProductName');
	/* 	$modelcount = count($lines);
		for ($x = $modelcount; $x <= 19; $x++) 
		{ 
			$lines[$x] = new PurchaseLines();
		} */
		return $this->render('update', [
			'model' => $model, 'suppliers' => $suppliers, 'lines' => $lines, 
			'products' => $products, 'pricelist' => $pricelist, 'usageunits' => $usageunits,
			'quotations' => $quotations,
			'rights' => $this->rights,
			'projects' => $projects,
		]);		
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		if ($model->save())
		{
			$result = UsersController::sendEmailNotification(28); 
			return $this->redirect(['view', 'id' => $model->PurchaseID]);
		}
	}

public function Getunitprice($SupplierID, $ProductID, $SupplierCode)
{
	$unitprice = 0;
	$model = PriceList::findone(['SupplierCode' => $SupplierCode, 'SupplierID' => $SupplierID]);
	if ($model)
	{
		$unitprice = $model->Price;
	} else
	{
		$model = Product::findone(['ProductID' => $ProductID]);
		if ($model)
		{
			$unitprice = $model->UnitPrice;
		}
	}	
	return $unitprice;
}

public function actionGetunitprice($SupplierID, $ProductID, $SupplierCode)
{
	$unitprice = 0;
	$model = PriceList::findone(['SupplierCode' => $SupplierCode, 'SupplierID' => $SupplierID]);
	if ($model)
	{
		$unitprice = $model->Price;
	} else
	{
		$model = Product::findone(['ProductID' => $ProductID]);
		if ($model)
		{
			$unitprice = $model->UnitPrice;
		}
	}	
	$channel = array('UnitPrice' => $unitprice );	
	$json = json_encode($channel);
	echo $json;
}

	public function actionPurchaseorder($id, $returnlink)
	{
		$Title = 'Purchase Order';
		
		$dataProvider = new ActiveDataProvider([
				'query' => PurchaseLines::find()->joinWith('product')->where(['PurchaseID'=> $id]),
			]);
		$model = Purchases::find()->where(['PurchaseID'=> $id])
								->joinWith('approvalstatus')
								->joinWith('suppliers')
								->joinWith('approvers')
								->one();
								
		//print_r($model); exit;
		$company = Company::find()->where(['CompanyID'=>1])->one();
		
		$content = $this->renderPartial('purchaseorder', ['model' => $model, 
															'dataProvider' => $dataProvider,
															'company' => $company,														  
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
			//'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
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
			'content' => $content,
			// 'months' => $months,
			// 'years' => $years,
			'model' => $model,
			// 'products' => $products,
			'Filter' => false,
			'returnlink' => $returnlink,
		]);
	}

	/**
	 * Deletes an existing Purchases model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

public function actionClose($id)
	{
		$model = $this->findModel($id);
	$model->Closed = 1;
	if ($model->save())
	{
		return $this->redirect(['view', 'id' => $id]);
	}
	}

public function actionGetfields($id, $SupplierID)
{
	$UserID = Yii::$app->user->identity->UserID;
	$usageunits = ArrayHelper::map(UsageUnit::find()->all(), 'UsageUnitID', 'UsageUnitName');
	$usercategories = ArrayHelper::getColumn(UserCategory::find()->where(['UserID' => $UserID, 'Selected' => 1])->all(),'ProductCategoryID');

	$scategory = ArrayHelper::getColumn(SupplierCategory::find()->where(['SupplierID' => $SupplierID, 'Selected' => 1])->all(),'ProductCategoryID');

	$suppliercategory = array(0);
	foreach ($scategory as $key => $value)
	{
		if (in_array($value, $usercategories))
		{
			$suppliercategory[] = $value;
		}
	}

	$products = ArrayHelper::map(Product::find()->where("ProductCategoryID IN (".implode(",",$suppliercategory).")
															OR ProductCategory2ID IN (".implode(",",$suppliercategory).")
															OR ProductCategory3ID IN (".implode(",",$suppliercategory).")")
												->all(), 'ProductID', 'ProductName');
	$row = $id -1;
	$Fields[0] = $id.'<input id="purchaselines-'.$row.'-purchaselineid" class="form-control" name="PurchaseLines['.$row.'][PurchaseLineID]" type="hidden">';
	
	$str = '<select id="purchaselines-'.$row.'-productid" class="form-control-min" name="PurchaseLines['.$row.'][ProductID]" onchange="populate_unitprice('.$row.',1)"><option value=""></option>';
	
	foreach ($products as $key => $value)
	{
		$str .= '<option value="'.$key.'">'.$value.'</option>';
	}		
	$str .= '</select>';
	
	$pricelist = ArrayHelper::map(PriceList::find()->where(['SupplierID' => $SupplierID])->all(), 'SupplierCode', 'ProductName');
	
	$str1 = '<select id="purchaselines-'.$row.'-suppliercode" class="form-control-min" name="PurchaseLines['.$row.'][SupplierCode]" onchange="populate_unitprice(this.value, '.$row.',1)"><option value=""></option>';
	foreach ($pricelist as $key => $value)
	{
		$str1 .= '<option value="'.$key.'">'.$value.'</option>';
	}		
	$str1 .= '</select>';

	$Fields[1] = $str;
	$Fields[2] = $str1;
	$Fields[3] = '<input id="purchaselines-'.$row.'-quantity" class="form-control-min" name="PurchaseLines['.$row.'][Quantity]" onchange="populate_unitprice('.$row.',1)" type="text">';
	$str2 = '<select id="purchaselines-'.$row.'-usageunitid" class="form-control-min" name="PurchaseLines['.$row.'][UsageUnitID]"><option value=""></option>';

	foreach ($usageunits as $key => $value)
	{
		$str2 .= '<option value="'.$key.'">'.$value.'</option>';
	}
	$str2 .= '</select>';
	$Fields[4] = $str2;
	$Fields[5] = '<input id="purchaselines-'.$row.'-unitprice" class="form-control-min" name="PurchaseLines['.$row.'][UnitPrice]" readonly="true" style="text-align:right" type="text">';
	$Fields[6] = '<input id="purchaselines-'.$row.'-unit_total" class="form-control-min" name="PurchaseLines['.$row.'][Unit_Total]" value="0" disabled="true" style="text-align:right" type="text">';
	$json = json_encode($Fields);
	echo $json;
}

	/**
	 * Finds the Purchases model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Purchases the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Purchases::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	// public function actionQuotations($id)
	// {
	// 	$model = Quotation::find()->where(['SupplierID' => $id])->all();
			
	// 	if (!empty($model)) {
	// 		foreach ($model as $item) {
	// 			echo "<option value='" . $item->QuotationID . "'>" . $item->Description . "</option>";
	// 		}
	// 	} else {
	// 		echo '<option>-</option>';
	// 	}
	// }

	
	public function actionQuotations($id)
	{
		$model = Quotation::find()->where(['ProjectID' => $id, 'ApprovalStatusID' => 3])->orderBy('QuotationID DESC')->all();
		// print_r($model); exit;
		echo '<option>Select...</option>';
		if (!empty($model)) {
			foreach ($model as $item) {
				echo "<option value='" . $item->QuotationID . "'>" . $item->Description . "</option>";
			}
		}
	}

	public function actionSuppliers($id)
	{
		$model = QuotationSupplier::find()->joinWith('suppliers')->where(['QuotationID' => $id])->all();
		// print_r($model); exit;
		echo '<option>Select...</option>';
		if (!empty($model)) {
			foreach ($model as $item) {
				echo "<option value='" . $item->suppliers->SupplierID . "'>" . $item->suppliers->SupplierName . "</option>";
			}
		}
	}
}
