<?php

namespace backend\controllers;

use Yii;
use app\models\Quotation;
use app\models\QuotationProducts;
use app\models\Product;
use app\models\Suppliers;
use app\models\Company;
use app\models\Requisition;
use app\models\QuotationSupplier;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\controllers\UsersController;
use app\models\FilterData;
use app\models\QuotationTypes;
use app\models\Accounts;
use app\models\ApprovalNotes;

use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(41);

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
	 * Lists all Quotation models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Quotation::find(),
			'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Quotation model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => QuotationProducts::find()->joinWith('product')
										->where(['QuotationID'=> $id]),
		]);
	
		$supplierProvider = new ActiveDataProvider([
			'query' => QuotationSupplier::find()->joinWith('suppliers')
										->where(['QuotationID'=> $id]),
		]);

		$approvalNotesProvider = new ActiveDataProvider([
			'query' => ApprovalNotes::find()->where(['ApprovalID'=> $id, 'ApprovalTypeID' => 3]),
	  	]);
	
		$model = Quotation::find()->where(['QuotationID'=> $id])
							->joinWith('approvalstatus')
							->joinWith('users')
							->one();
							
		return $this->render('view', [
			'model' => $model, 'dataProvider' => $dataProvider, 'supplierProvider' => $supplierProvider,
			'approvalNotesProvider' => $approvalNotesProvider
		]);
	}

	/**
	 * Creates a new Quotation model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		
		$model = new Quotation();
		$model->CreatedBy = $UserID;
			
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$QuotationID = $model->QuotationID;
			
			$params = Yii::$app->request->post();
			$lines = $params['QuotationProducts'];
			
			foreach ($lines as $key => $line) {
				if ($line['ProductID'] != '') {
					$_line = new QuotationProducts();
					$_line->QuotationID = $QuotationID;
					$_line->ProductID = ($line['QuotationTypeID'] == 1) ? $line['ProductID'] : 0;
					$_line->AccountID = ($line['QuotationTypeID'] != 1) ? $line['ProductID'] : 0;
					$_line->Quantity = $line['Quantity'];
					$_line->QuotationTypeID = $line['QuotationTypeID'];
					$_line->save();
				}
			}
			
			$quotationsuppliers = $params['QuotationSupplier'];
			foreach ($quotationsuppliers as $key => $line) {
				if ($line['QuotationSupplierID'] == '') {
					if ($line['SupplierID'] != '') {
						$_line = new QuotationSupplier();
						$_line->QuotationID = $QuotationID;
						$_line->SupplierID = $line['SupplierID'];
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else {
					$_line = QuotationSupplier::findOne($line['QuotationSupplierID']);
					$_line->QuotationID = $id;
					$_line->SupplierID = $line['SupplierID'];
					$_line->save();
				}
			}
			
				return $this->redirect(['view', 'id' => $model->QuotationID]);
		}

		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$accounts = ArrayHelper::map(Accounts::find()->all(), 'AccountID', 'AccountName');
		$quotationTypes = ArrayHelper::map(QuotationTypes::find()->all(), 'QuotationTypeID', 'QuotationTypeName');
		$requisitions = ArrayHelper::map(Requisition::find()->all(), 'RequisitionID', 'Description');
		
		$productmodelcount = 0;
		$suppliermodelcount = 0;
		
		if (Yii::$app->request->post()) {
			//print_r(Yii::$app->request->post()); exit;
			$params = Yii::$app->request->post();
			
			foreach ($params['QuotationProducts'] as $x => $product) {
				$lines[$x] = new QuotationProducts();
				$lines[$x]['ProductID'] = $product['ProductID'];
				$lines[$x]['Quantity'] = $product['Quantity'];
			}
			foreach ($params['QuotationSupplier'] as $x => $supplier) {
				$quotationsuppliers[$x] = new QuotationSupplier();
				$quotationsuppliers[$x]['SupplierID'] = $supplier['SupplierID'];
			}
			
			$productmodelcount = count($lines);
			$suppliermodelcount = count($quotationsuppliers);
		}
		
		for ($x = $productmodelcount; $x <= 9; $x++) {
			$lines[$x] = new QuotationProducts();
		}
		
		for ($x = $suppliermodelcount; $x <= 9; $x++) {
			$quotationsuppliers[$x] = new QuotationSupplier();
		}

		return $this->render('create', [
			'model' => $model,
			'suppliers' => $suppliers,
			'lines' => $lines, 
			'products' => $products,
			'quotationsuppliers' => $quotationsuppliers,
			'quotationTypes' => $quotationTypes,
			'accounts' => $accounts,
			'requisitions' => $requisitions
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
		$quotationProducts = QuotationProducts::find()->where(['QuotationID' => $id])->all();
		$quotationsuppliers = QuotationSupplier::find()->where(['QuotationID' => $id])->all();

		// Convert Lines
		foreach ($quotationProducts as $key => $line) {
			$lines[$key] = new QuotationProducts();
			$lines[$key] = $line;
			if ($line->QuotationTypeID != 1) {
				$lines[$key]->ProductID = $line->AccountID;
			}
			// $lines[$key]->QuotationID 
			// $lines[$key]->ProductID 
			// $lines[$key]->Quantity 
			// $lines[$key]->QuotationTypeID
			// $lines[$key]->AccountID
		}

	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['QuotationProducts'];
			
			foreach ($lines as $key => $line) {
				if ($line['QuotationProductID'] == '') {
					if ($line['ProductID'] != '') {
						$_line = new QuotationProducts();
						$_line->QuotationID = $id;
						$_line->ProductID = ($line['QuotationTypeID'] == 1) ? $line['ProductID'] : 0;
						$_line->AccountID = ($line['QuotationTypeID'] != 1) ? $line['ProductID'] : 0;
						$_line->Quantity = $line['Quantity'];
						$_line->QuotationTypeID = $line['QuotationTypeID'];
						$_line->save();
					}
				} else {
					$_line = QuotationProducts::findOne($line['QuotationProductID']);
					$_line->QuotationID = $id;
					$_line->ProductID = ($line['QuotationTypeID'] == 1) ? $line['ProductID'] : 0;
					$_line->AccountID = ($line['QuotationTypeID'] != 1) ? $line['ProductID'] : 0;
					$_line->Quantity = $line['Quantity'];
					$_line->save();
				}
			}
			
			$quotationsuppliers = $params['QuotationSupplier'];
			foreach ($quotationsuppliers as $key => $line) {
				if ($line['QuotationSupplierID'] == '') {
					if ($line['SupplierID'] != '') {
						$_line = new QuotationSupplier();
						$_line->QuotationID = $id;
						$_line->SupplierID = $line['SupplierID'];
						$_line->save();
					}
				} else {
					$_line = QuotationSupplier::findOne($line['QuotationSupplierID']);
					$_line->QuotationID = $id;
					$_line->SupplierID = $line['SupplierID'];
					$_line->save();
				}
			}
			
			return $this->redirect(['view', 'id' => $model->QuotationID]);
		}
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$accounts = ArrayHelper::map(Accounts::find()->all(), 'AccountID', 'AccountName');
		$quotationTypes = ArrayHelper::map(QuotationTypes::find()->all(), 'QuotationTypeID', 'QuotationTypeName');
		$requisitions = ArrayHelper::map(Requisition::find()->all(), 'RequisitionID', 'Description');

		$products[1] = $products;
		$products[2] = $accounts;
		
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			
			foreach ($params['QuotationProducts'] as $x => $product) {
				$lines[$x] = new QuotationProducts();
				$lines[$x]['ProductID'] = $product['ProductID'];
				$lines[$x]['Quantity'] = $product['Quantity'];
				$lines[$x]['QuotationProductID'] = $product['QuotationProductID'];
			}
			foreach ($params['QuotationSupplier'] as $x => $supplier) {
				$quotationsuppliers[$x] = new QuotationSupplier();
				$quotationsuppliers[$x]['SupplierID'] = $supplier['SupplierID'];
				$quotationsuppliers[$x]['QuotationSupplierID'] = $supplier['QuotationSupplierID'];					
			}
			$productmodelcount = count($lines);
			$suppliermodelcount = count($quotationsuppliers);
		} else {
			$modelcount = count($lines);
			for ($x = $modelcount; $x <= 9; $x++) {
				$lines[$x] = new QuotationProducts();
			}
			
			$modelcount = count($quotationsuppliers);
			for ($x = $modelcount; $x <= 9; $x++) {
				$quotationsuppliers[$x] = new QuotationSupplier();
			}
		}
		
		return $this->render('update', [
			'model' => $model, 'suppliers' => $suppliers, 'lines' => $lines, 
			'products' => $products, 'quotationsuppliers' => $quotationsuppliers,
			'quotationTypes' => $quotationTypes,
			'accounts' => $accounts,
			'requisitions' => $requisitions
		]);
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
		if (($model = Quotation::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionSubmit($id)
	{
		$suppliers = QuotationSupplier::find()->where(['QuotationID' => $id])->all();
		if (count($suppliers) > 0) {
			$model = $this->findModel($id);
			$model->ApprovalStatusID = 1;
			if ($model->save()) {
				$result = UsersController::sendEmailNotification(29);
				return $this->redirect(['view', 'id' => $model->QuotationID]);
			}
		} else {
			Yii::$app->session->setFlash('error', "You have not selected suppliers for the quotation");
			return $this->redirect(['view', 'id' => $id]);
		}
	}

	public function actionRfq($id)
	{
		$Title = 'Request for Quotation';
		$SupplierID = 0;
		$params = Yii::$app->request->post();
		if (!empty($params) && $params['FilterData']['SupplierID']!='') {
			$SupplierID = $params['FilterData']['SupplierID'];
			$suppliers = Suppliers::find()->where("SupplierID = $SupplierID")->all();
		} else {
			$suppliers = Suppliers::find()->where("SupplierID IN (SELECT DISTINCT SupplierID FROM quotationsupplier WHERE QuotationID = $id)")->all();
		}
		
		$dataProvider = new ActiveDataProvider([
				'query' => QuotationProducts::find()->joinWith('product')->where(['QuotationID'=> $id]),
			]);
		$quotation = Quotation::find()->where(['QuotationID'=> $id])
								->joinWith('approvalstatus')
								->joinWith('approvers')
								->one();
								
		
		$company = Company::find()->where(['CompanyID'=>1])->one();
		
		$content = $this->renderPartial('rfq', ['model' => $quotation, 
															'dataProvider' => $dataProvider,
															'company' => $company,	
															'suppliers' => $suppliers,
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
		// return $pdf->render(); 
		$content = $pdf->render('', 'S'); 
		$content = chunk_split(base64_encode($content));
		
		$suppliers = ArrayHelper::map(Suppliers::find()->where("SupplierID IN (SELECT DISTINCT SupplierID FROM quotationsupplier WHERE QuotationID = $id)")->all(), 'SupplierID', 'SupplierName');
		
		$model = new FilterData();
		$model->SupplierID = $SupplierID;

		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
				'content' => $content, 'quotation' => $quotation, 
			'model' => $model, 'Filter' => false, 'suppliers' => $suppliers
			]);
	}

	public function actionGetproductsfields($id)
	{
		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		
		$row = $id -1;
		$Fields[0] = $id.'<input type="hidden" id="quotationproducts-'.$row.'-quotationproductid" class="form-control" name="QuotationProducts['.$row.'][QuotationProductID]">';
		
		$str = '<select id="quotationproducts-'.$row.'-productid" class="form-control-min" name="QuotationProducts['.$row.'][ProductID]"><option value=""></option>';
		
		foreach ($products as $key => $value)
		{
			$str .= '<option value="'.$key.'">'.$value.'</option>';
		}		
		$str .= '</select>';

		$Fields[1] = $str;
		$Fields[2] = '<input type="text" id="quotationproducts-'.$row.'-quantity" class="form-control-min" name="QuotationProducts['.$row.'][Quantity]">';

		$json = json_encode($Fields);
		echo $json;
	}

	public function actionGetsupplierfields($id)
	{
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		
		$row = $id -1;
		$Fields[0] = $id.'<input type="hidden" id="quotationsupplier-'.$row.'-quotationsupplierid" class="form-control" name="QuotationSupplier['.$row.'][QuotationSupplierID]">';
		
		$str = '<select id="quotationsupplier-0-supplierid" class="form-control" name="QuotationSupplier[0][SupplierID]"><option value=""></option>';
		
		foreach ($suppliers as $key => $value)
		{
			$str .= '<option value="'.$key.'">'.$value.'</option>';
		}		
		$str .= '</select>';

		$Fields[1] = $str;

		$json = json_encode($Fields);
		echo $json;
	}

	public function actionGetTypes($id, $TypeID)
	{
		if ($TypeID == 1) {
			$model = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		} else {
			$model = ArrayHelper::map(Accounts::find()->all(), 'AccountID', 'AccountName');
		}
			
		if (!empty($model)) {
			foreach ($model as $key => $item) {
				echo "<option value='" . $key . "'>" . $item . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}
}
