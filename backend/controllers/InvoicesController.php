<?php

namespace backend\controllers;

use Yii;
use app\models\Invoices;
use app\models\Suppliers;
use app\models\Purchases;
use app\models\Documents;
use app\models\DeliveryLines;
use app\models\Search;
use app\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\web\UploadedFile;

/**
 * InvoicesController implements the CRUD actions for Invoices model.
 */
class InvoicesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(25);

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
	public function actionIndex()
	{
		$searchfor = [1 => 'ID', 2 => 'PO No.', 3 => 'Amount'];
		$search = new Search();
		$params = Yii::$app->request->post();
		if (!empty($params)) {			
			$where = '';
			if ($params['Search']['searchfor'] == 1) {
				$searchstring = $params['Search']['searchstring'];
				$where = "InvoiceID = '$searchstring'";
			} elseif ($params['Search']['searchfor'] == 2) {
				$searchstring = $params['Search']['searchstring']; 
				$where = "PurchaseID like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 3) {
				$searchstring = $params['Search']['searchstring']; 
				$where = "Amount = '$searchstring'";
			}
			$dataProvider = new ActiveDataProvider([
				'query' => Invoices::find()->where($where),
			]);
	
			$search->searchfor = $params['Search']['searchfor'];
			$search->searchstring = $params['Search']['searchstring'];
		} else {
			$dataProvider = new ActiveDataProvider([
				'query' => Invoices::find(),
			]);
		}
		
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'search' => $search,
			'searchfor' => $searchfor,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single Invoices model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$PurchaseID = $model->PurchaseID;
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
		$documents = Documents::find()->where(['RefNumber' => $id, 'DocumentTypeID' => 1])->all();

		// Display Documents 
		$documentProvider = new ActiveDataProvider([
			'query' => Documents::find()->where(['RefNumber' => $id, 'DocumentTypeID' => 1]),
			'pagination' => false,
		]);

		return $this->render('view', [
			'model' => $model,
			'deliveries' => $deliveries,
			'purchases' => $purchases,
			'rights' => $this->rights,
			'documents' => $documents,
			'documentProvider' => $documentProvider,
		]);
	}

	/**
	 * Creates a new Invoices model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Invoices();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->submit = 0;

		// $upload = new UploadForm();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2');
			if ($model->upload($model->InvoiceID, 1)) {
				/*  echo 'file is uploaded successfully';
				 return; */
			}
			return $this->redirect(['view', 'id' => $model->InvoiceID]);
		}
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$purchases = []; // ArrayHelper::map(Purchases::find()->all(), 'PurchaseID', 'PurchaseID');

		// Display Documents 
		$documentProvider = new ActiveDataProvider([
			'query' => Documents::find()->where(['RefNumber' => 0, 'DocumentTypeID' => 1]),
			'pagination' => false,
		]);

		return $this->render('create', [
			'model' => $model,
			'suppliers' => $suppliers,
			'purchases' => $purchases,
			'rights' => $this->rights,
			'documentProvider' => $documentProvider,
		]);
	}

	/**
	 * Updates an existing Invoices model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2');
			if ($model->upload($model->InvoiceID, 1)) {
				/*  echo 'file is uploaded successfully';
				 return; */
			}
			return $this->redirect(['view', 'id' => $model->InvoiceID]);
		}
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$supplierID = $model->SupplierID;
		$sql = "Select PurchaseID, concat(PurchaseName, ' ( Ksh: ', COALESCE(format(`Amount`,2), format(0,2)), ')') as PurchaseName FROM (
			SELECT `PurchaseID`, concat(PurchaseID, ' - ', DATE(CreatedDate)) AS `PurchaseName`, (Select sum(Quantity * UnitPrice) as Amount FROM purchaselines
				WHERE PurchaseID = purchases.PurchaseID) as Amount FROM `purchases` WHERE `SupplierID`= $supplierID
			) temp"; 
		$purchases = ArrayHelper::map(Purchases::findBySql($sql)->asArray()->all(), 'PurchaseID', 'PurchaseName');

		// Display Documents 
		$documentProvider = new ActiveDataProvider([
			'query' => Documents::find()->where(['RefNumber' => $id, 'DocumentTypeID' => 1]),
			'pagination' => false,
		]);

		return $this->render('update', [
			'model' => $model,
			'suppliers' => $suppliers,
			'purchases' => $purchases,
			'rights' => $this->rights,
			'documentProvider' => $documentProvider,
		]);
	}

	/**
	 * Deletes an existing Invoices model.
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
	 * Finds the Invoices model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Invoices the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Invoices::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionPurchases($id)
	{
		// $model = Purchases::find()->where(['SupplierID' => $id])->all();
		$sql = "Select PurchaseID, concat(PurchaseName, ' ( Ksh: ', COALESCE(format(`Amount`,2), format(0,2)), ')') as PurchaseName FROM (
					SELECT `PurchaseID`, concat(PurchaseID, ' - ', DATE(CreatedDate)) AS `PurchaseName`, (Select sum(Quantity * UnitPrice) as Amount FROM purchaselines
						WHERE PurchaseID = purchases.PurchaseID) as Amount FROM `purchases` WHERE `SupplierID`= $id
					) temp"; 
		$model = Purchases::findBySql($sql)->asArray()->all();
			
		if (!empty($model)) {
			foreach ($model as $item) {
				echo "<option value='" . $item['PurchaseID'] . "'>" . $item['PurchaseName'] . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		$model->submit = 1;
		if ($model->save()) {
			// $result = UsersController::sendEmailNotification(29);
			return $this->redirect(['view', 'id' => $model->InvoiceID]);
		} else {
			// print_r($model->getErrors()); exit;
		}
	}

	public function actionDeleteDocument($id, $InvoiceID)
	{
		Documents::findOne($id)->delete();
		return $this->redirect(['update', 'id' => $InvoiceID]);
	}

	public function actionViewDocument($id, $InvoiceID, $source='view')
	{
		ini_set('max_execution_time', 5*60); // 5 minutes
		$model = Documents::findOne($id);
		ob_clean();

		$file = 'uploads/' . $model->FileName;

		if (file_exists($file)) {
			Yii::$app->response->sendFile($file)->send();
			return;
		}
		if ($source == 'view') {
			return $this->redirect(['view', 'id' => $InvoiceID]);
		} else {
			return $this->redirect(['update', 'id' => $InvoiceID]);
		}		
	}
}
