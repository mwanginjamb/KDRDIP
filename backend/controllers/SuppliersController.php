<?php

namespace backend\controllers;

use Yii;
use app\models\Suppliers;
use app\models\PriceList;
use app\models\Purchases;
use app\models\UploadFile;
use app\models\SupplierSearch;
use app\models\Countries;
use app\models\SupplierContact;
use app\models\SupplierCategory;
use app\models\Categories;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * SuppliersController implements the CRUD actions for Suppliers model.
 */
class SuppliersController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(50);

		$rightsArray = []; 
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update', 'details', 'pricelist', 'uploadpricelist', 'orders');
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
			'only' => ['index', 'view', 'create', 'update', 'delete', 'details', 'pricelist', 'uploadpricelist', 'orders'],
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

	public function beforeAction($action)  
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	} 	

	/**
	 * Lists all Suppliers models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchfor = array (1=> 'ID', 2 => 'Supplier Name', 3 => 'Mobile', 4 => 'Email');
			$search = new SupplierSearch();
		$params = Yii::$app->request->post();
		if (!empty($params))
		{
			$where = '';
			if ($params['SupplierSearch']['searchfor'] == 1) {
				$searchstring = $params['SupplierSearch']['searchstring']; 
				$where = "SupplierID = '$searchstring'";				
			} elseif ($params['SupplierSearch']['searchfor'] == 2) {
				$searchstring = $params['SupplierSearch']['searchstring']; 
				$where = "SupplierName like '%$searchstring%'";				
			} elseif ($params['SupplierSearch']['searchfor'] == 3) {
				$searchstring = $params['SupplierSearch']['searchstring']; 
				$where = "suppliers.Mobile like '%$searchstring%'";
			} elseif ($params['SupplierSearch']['searchfor'] == 4) {
				$searchstring = $params['SupplierSearch']['searchstring']; 
				$where = "suppliers.Email like '%$searchstring%'";
			}
			$suppliers = Suppliers::find()->where($where);
			$search->searchfor = $params['SupplierSearch']['searchfor'];
			$search->searchstring = $params['SupplierSearch']['searchstring'];
		} else {
			$suppliers = Suppliers::find();
		}
	
		$dataProvider = new ActiveDataProvider([
			'query' => $suppliers,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Suppliers model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$priceListProvider = new ActiveDataProvider([
			'query' => PriceList::find()->where(['SupplierID' => $id]),
		]);
		
		$ordersProvider = new ActiveDataProvider([
			'query' => Purchases::find()->joinWith('suppliers')->joinWith('approvalstatus')->where(['purchases.SupplierID' => $id]),
		]);

		$categoriesProvider = new ActiveDataProvider([
			'query' => SupplierCategory::find()->joinWith('productcategory')->where(['SupplierID' => $id, 'Selected' => 1]),
	 	]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'priceListProvider' => $priceListProvider,
			'ordersProvider' => $ordersProvider,
			'categoriesProvider' => $categoriesProvider,
			'rights' => $this->rights,
		]);
	}

	public function actionViewdetails($id)
	{
		return $this->renderPartial('viewdetails', [
			'model' => $this->findModel($id),
		]);
	}	

	/**
	 * Creates a new Suppliers model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
	
		$model = new Suppliers();
		$model->CreatedBy = $UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {		
			$params = Yii::$app->request->post();
			$contacts = $params['SupplierContact'];
			
			foreach ($contacts as $key => $contact)
			{				 
				$_contact = new SupplierContact();
				$_contact->SupplierID = $model->SupplierID;
				$_contact->ContactName = $contact['ContactName'];
				$_contact->Designation = $contact['Designation'];
				// $_contact->Telephone = $contact['Telephone'];
				$_contact->Mobile = $contact['Mobile'];
				$_contact->Email = $contact['Email'];
				$_contact->save();
				//print_r($_line->getErrors());
			}
			return $this->redirect(['view', 'id' => $model->SupplierID]);
		} else {
			$country = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');
			for ($x = 0; $x <= 2; $x++) {
				$contacts[$x] = new SupplierContact();
			}
			return $this->render('create', [
				'model' => $model, 'country' => $country, 'contacts' => $contacts,
				'rights' => $this->rights,
			]);
		}
	}

	/**
	 * Updates an existing Suppliers model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		if (Yii::$app->request->post() && isset(Yii::$app->request->post()['Categories'])) {
			// print_r(Yii::$app->request->post()); exit;
			$params = Yii::$app->request->post();
			$Categories = $params['Categories'];
			
			foreach ($Categories as $key => $Category) {
				if ($Category['SupplierCategoryID']) {
					// update
					$_model = SupplierCategory::findone($Category['SupplierCategoryID']);
					$_model->Selected = $Category['Selected'];
					$_model->save();
				} else {
					// Insert
					$_model = new SupplierCategory();
					$_model->ProductCategoryID = $Category['ProductCategoryID'];
					$_model->SupplierID = $id;
					$_model->Selected = $Category['Selected'];
					$_model->save();
				}
			}
		}
		$model = $this->findModel($id);
		$contacts = SupplierContact::find()->where(['SupplierID' => $id])->all();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$contacts = $params['SupplierContact'];
			
			foreach ($contacts as $key => $contact) {					
				if ($contact['SupplierContactID'] == '') {
					$_contact = new SupplierContact();
					$_contact->SupplierID = $model->SupplierID;
					$_contact->ContactName = $contact['ContactName'];
					$_contact->Designation = $contact['Designation'];
					// $_contact->Telephone = $contact['Telephone'];
					$_contact->Mobile = $contact['Mobile'];
					$_contact->Email = $contact['Email'];
					$_contact->save();					
				} else {
					$_contact = SupplierContact::findOne($contact['SupplierContactID']);
					$_contact->SupplierID = $model->SupplierID;
					$_contact->ContactName = $contact['ContactName'];
					$_contact->Designation = $contact['Designation'];
					$_contact->Telephone = $contact['Telephone'];
					$_contact->Mobile = $contact['Mobile'];
					$_contact->Email = $contact['Email'];
					$_contact->save();
					//print_r($_contact->getErrors());exit;	
				}
			}
			return $this->redirect(['update', 'id' => $model->SupplierID]);			
		} else 
		{
			$country = ArrayHelper::map(Countries::find()->all(), 'CountryID', 'CountryName');
			$modelcount = count($contacts);
			for ($x = $modelcount; $x <= 2; $x++) {
				$contacts[$x] = new SupplierContact();
			}

			$ordersProvider = new ActiveDataProvider([
				'query' => Purchases::find()->joinWith('suppliers')->joinWith('approvalstatus')->where(['purchases.SupplierID' => $id]),
			]);
			$priceList = PriceList::find()->where(['SupplierID' => $id])->all();

			$sql = "SELECT productcategory.*, suppliercategory.ProductCategoryID as PCID, SupplierCategoryID, 
						SupplierID, Selected FROM suppliercategory 
						RIGHT JOIN productcategory ON productcategory.ProductCategoryID = suppliercategory.ProductCategoryID
						AND SupplierID = '$id'";
			
			$supplierCategory = SupplierCategory::findBySql($sql)->asArray()->all();
			foreach ($supplierCategory as $key => $row) {
				$_categories = new Categories();
				$_categories->SupplierCategoryID = $row['SupplierCategoryID'];
				$_categories->ProductCategoryID = $row['ProductCategoryID'];
				$_categories->ProductCategoryName = $row['ProductCategoryName'];
				$_categories->SupplierID = $row['SupplierID'];
				$_categories->PCID = $row['PCID'];
				$_categories->Selected = $row['Selected'];
				$categories[$key] = $_categories;
			}

			return $this->render('update', [
				'model' => $model, 'country' => $country, 'contacts' => $contacts,
				'priceList' => $priceList,
				'ordersProvider' => $ordersProvider,
				'categories' => $categories,
				'rights' => $this->rights,
			]);
		}
	}

	public function actionDetails($id)
	{
		$model = $this->findModel($id);
		$contacts = SupplierContact::find()->where(['SupplierID' => $id])->all();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$contacts = $params['SupplierContact'];
			
			foreach ($contacts as $key => $contact) {
				//print_r($lines);exit;
					
				if ($contact['SupplierContactID'] == '') {				
					$_contact = new SupplierContact();
					$_contact->SupplierID = $model->SupplierID;
					$_contact->ContactName = $contact['ContactName'];
					$_contact->Designation = $contact['Designation'];
					$_contact->Telephone = $contact['Telephone'];
					$_contact->Mobile = $contact['Mobile'];
					$_contact->Email = $contact['Email'];
					$_contact->save();
				} else {						
					$_contact = SupplierContact::findOne($contact['SupplierContactID']);
					$_contact->SupplierID = $model->SupplierID;
					$_contact->ContactName = $contact['ContactName'];
					$_contact->Designation = $contact['Designation'];
					$_contact->Telephone = $contact['Telephone'];
					$_contact->Mobile = $contact['Mobile'];
					$_contact->Email = $contact['Email'];
					$_contact->save();	
				}
			}
			return $this->redirect(['update', 'id' => $model->SupplierID]);			
		}
		$model = $this->findModel($id);
		$contacts = SupplierContact::find()->where(['SupplierID' => $id])->all();
		$country = ArrayHelper::map(Country::find()->all(), 'CountryID', 'CountryName');
		$modelcount = count($contacts);
		for ($x = $modelcount; $x <= 2; $x++) {
			$contacts[$x] = new SupplierContact();
		}
		return $this->renderPartial('details', [
			'model' => $model, 'country' => $country, 'contacts' => $contacts
		]);
	}

	public function actionPricelist($id)
	{
		$model = PriceList::find()->where(['SupplierID' => $id])->all();
		
		$params = Yii::$app->request->post();
		
		if (!empty($params)) {
			$PriceList = $params['PriceList'];
			foreach ($PriceList as $key => $ListItem)
			{
				$SupplierCode 	= $ListItem['SupplierCode'];
				$ProductName 	= $ListItem['ProductName'];
				$UnitofMeasure	= $ListItem['UnitofMeasure'];
				$Price 			= $ListItem['Price'];
				
				$model = PriceList::find()->where(['SupplierCode' => $SupplierCode, 'SupplierID' => $id])->one();
				if (empty($model)) {
					$model = new PriceList();
					$model->SupplierID = $id;
					$model->SupplierCode = $SupplierCode;
				}				
				
				$model->ProductName = $ProductName;
				$model->UnitofMeasure = $UnitofMeasure;
				$model->Price = $Price;
				
				$model->save();
			}
			echo "0";
			//print_r($params); exit;
		} else {
			$supplier = $this->findModel($id);
			return $this->renderPartial('pricelist', [
				'products' => $model, 'supplier' => $supplier
			]);
		}
	}

	public function actionCategories($id)
	{
		$sql = "SELECT ProductCategory.*, SupplierCategory.ProductCategoryID as PCID, SupplierCategoryID, SupplierID, Selected FROM SupplierCategory 
					RIGHT JOIN ProductCategory ON ProductCategory.ProductCategoryID = SupplierCategory.ProductCategoryID
					AND SupplierID = '$id'";
					
		$model = SupplierCategory::findBySql($sql)->asArray()->all();
		
		//print_r(Yii::$app->request->post());
		if (Yii::$app->request->post())
		{
			$params = Yii::$app->request->post();
			$Categories = $params['Categories'];
			
			//print_r($params); exit;
			
			foreach ($Categories as $key => $Category)
			{
				if ($Category['SupplierCategoryID'])
				{
					// update
					$_model = SupplierCategory::findone($Category['SupplierCategoryID']);
					$_model->Selected = $Category['Selected'];
					$_model->save();
				} else
				{
					// Insert
					$_model = new SupplierCategory();
					$_model->ProductCategoryID = $Category['ProductCategoryID'];
					$_model->SupplierID = $id;
					$_model->Selected = $Category['Selected'];
					$_model->save();					
				}
			}
			echo "0";
			//print_r($params); exit;
		} else
		{
			
			//print_r($model); exit;
			
			foreach ($model as $key => $row)
			{
				$_categories = new Categories();
						$_categories->SupplierCategoryID = $row['SupplierCategoryID'];
						$_categories->ProductCategoryID = $row['ProductCategoryID'];
				$_categories->ProductCategoryName = $row['ProductCategoryName'];
				$_categories->SupplierID = $row['SupplierID'];
				$_categories->PCID = $row['PCID'];
				$_categories->Selected = $row['Selected'];
				$categories[$key] = $_categories;
			}
			//print_r($categories); exit;
			
			$supplier = $this->findModel($id);
			return $this->renderPartial('categories', [
				'categories' => $categories, 'supplier' => $supplier
			]);
		}
	}

	public function actionViewpricelist($id)
		{		
		$supplier = $this->findModel($id);
		
		$dataProvider = new ActiveDataProvider([
				'query' => PriceList::find()->where(['SupplierID' => $id]),
			]);

			return $this->renderPartial('viewpricelist', [
				'dataProvider' => $dataProvider, 'supplier' => $supplier
			]);
		
	}

	public function actionViewcategories($id)
		{		
		$supplier = $this->findModel($id);
		
		$dataProvider = new ActiveDataProvider([
				'query' => SupplierCategory::find()->joinWith('productcategory')->where(['SupplierID' => $id, 'Selected' => 1]),
			]);

			return $this->renderPartial('viewcategories', [
				'dataProvider' => $dataProvider, 'supplier' => $supplier
			]);
		
	}	

	public function actionUploadpricelist($id)
	{
		$params = Yii::$app->request->post();
		$message = '';
		
		if (!empty($params)) {
			$target_dir = Yii::$app->params['documentpath']; 
			$MaxFileSize = Yii::$app->params['MAX_FILE_SIZE'];
			//print_r($_FILES['UploadFile']); exit;
			$target_file = $target_dir . basename($_FILES['UploadFile']['name']['myFile']);
				
			$Filename = basename($_FILES['UploadFile']['name']['myFile']);

			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			if ($_FILES['UploadFile']['size']['myFile'] > $MaxFileSize) {
				$message = 'Sorry, the file is too large.';
			} else {
				if (move_uploaded_file($_FILES['UploadFile']['tmp_name']['myFile'], $target_file)) {
					//echo "The file ". $Filename. " has been uploaded.";
					$result = 0;
					$inputFileName = $target_dir.$Filename;
					require_once 'PHPExcel/PHPExcel/IOFactory.php';
					$objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
					$file_ext = preg_split("/\./", $inputFileName);
					if (end($file_ext) == 'xlsx') {
						$inputFileType = 'Excel2007';
					} else {
						$inputFileType = 'Excel5';
					}
					$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
					$objReader->setLoadAllSheets();
					$objPHPExcel = $objReader->load($inputFileName);
					$loadedSheetNames = $objPHPExcel->getSheetNames();
					foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
						$sheet = $objPHPExcel->getSheet($sheetIndex);
						$sheetData = $objPHPExcel->getSheet($sheetIndex)->toArray(null,true,true,true);
						//print_r($sheetData); exit;
						foreach ($sheetData as $key => $row) {
							//print_r($row); exit;
							if ($key>=2) {
								$SupplierCode	= (string) $row["A"];
								$ProductName	= (string) $row["B"];
								$UnitofMeasure	= (string) $row["C"];
								$Price			= $row["D"];

								$model = PriceList::find()->where(['SupplierCode' => $SupplierCode, 'SupplierID' => $id])->one();
								if (empty($model))
								{
									$model = new PriceList();
									$model->SupplierID = $id;
									$model->SupplierCode = $SupplierCode;
								}				
								
								$model->ProductName = $ProductName;
								$model->UnitofMeasure = $UnitofMeasure;
								$model->Price = $Price;
								
								$model->save();
								//print_r($model->getErrors());
							}
						}
					}
					return $this->redirect(['update', 'id' => $id]);
				} else {
					$message = 'Sorry, there was an error uploading your file.';
				}
			}
		}

		$model = new UploadFile();
		return $this->render('uploadpricelist', [
			'id' => $id,
			'model' => $model,
			'message' => $message
		]);
	}

	public function actionOrders($id)
	{
		$dataProvider = new ActiveDataProvider([
				'query' => Purchases::find()->joinWith('suppliers')->joinWith('approvalstatus')->where(['purchases.SupplierID' => $id]),
			]);

			return $this->renderPartial('orders', [
				'dataProvider' => $dataProvider,
			]);
	}

	public function actionDownloadtemplate()
	{
		// $source_dir = Yii::getAlias('@webroot') . Yii::$app->params['templates'];
		$source_dir = Yii::$app->params['templates'];
		$filename = $source_dir . 'Price List.xlsx';

/* 		// echo $filename; exit;
		ini_set('max_execution_time', 5*60); // 5 minutes
		if (file_exists($filename)) {
			Yii::$app->response->xSendFile($filename);
	  	} else {
			echo 'File not found';
		} */
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");
		header("Content-Length: " . filesize($filename));
		flush(); // this doesn't really matter.
		$fp = fopen($filename, 'r');
		while (!feof($fp)) {
			echo fread($fp, 65536);
			flush(); // this is essential for large downloads
		} 
		fclose($fp);
		exit;
	}

	/**
	 * Deletes an existing Suppliers model.
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
	 * Finds the Suppliers model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Suppliers the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Suppliers::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
