<?php

namespace backend\controllers;

use Yii;
use app\models\Invoices;
use app\models\Suppliers;
use app\models\Purchases;
use app\models\Deliveries;
use app\models\DeliveryLines;
use app\models\Search;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * InvoicesController implements the CRUD actions for Invoices model.
 */
class InvoicesController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
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
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
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

		return $this->render('view', [
			'model' => $model,
			'deliveries' => $deliveries,
			'purchases' => $purchases,
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

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->InvoiceID]);
		}
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$purchases = []; // ArrayHelper::map(Purchases::find()->all(), 'PurchaseID', 'PurchaseID');

		return $this->render('create', [
			'model' => $model,
			'suppliers' => $suppliers,
			'purchases' => $purchases,
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
			return $this->redirect(['view', 'id' => $model->InvoiceID]);
		}
		$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'SupplierID', 'SupplierName');
		$supplierID = $model->SupplierID;
		$sql = "Select PurchaseID, concat(PurchaseName, ' ( Ksh: ', COALESCE(format(`Amount`,2), format(0,2)), ')') as PurchaseName FROM (
			SELECT `PurchaseID`, concat(PurchaseID, ' - ', DATE(CreatedDate)) AS `PurchaseName`, (Select sum(Quantity * UnitPrice) as Amount FROM purchaselines
				WHERE PurchaseID = purchases.PurchaseID) as Amount FROM `purchases` WHERE `SupplierID`= $supplierID
			) temp"; 
		$purchases = ArrayHelper::map(Purchases::findBySql($sql)->asArray()->all(), 'PurchaseID', 'PurchaseName');
		return $this->render('update', [
			'model' => $model,
			'suppliers' => $suppliers,
			'purchases' => $purchases
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
		if ($model->save()) {
			$result = UsersController::sendEmailNotification(29);
			return $this->redirect(['view', 'id' => $model->InvoiceID]);
		}
	}
}
