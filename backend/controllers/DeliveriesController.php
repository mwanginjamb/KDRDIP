<?php

namespace backend\controllers;

use Yii;
use app\models\Deliveries;
use app\models\Purchases;
use app\models\Suppliers;
use app\models\DeliveryLines;
use app\models\StockAdjustment;
use app\models\Company;
use app\models\PurchaseLines;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use backend\controllers\RightsController;

/**
 * DeliveriesController implements the CRUD actions for Deliveries model.
 */
class DeliveriesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(18);

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
	 * Lists all Deliveries models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$UserID = Yii::$app->user->identity->UserID;
	
		/* $dataProvider = new ActiveDataProvider([
			'query' => Deliveries::find()->where(['deliveries.CreatedBy'=> $UserID]),
		'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]); */
		$dataProvider = new ActiveDataProvider([
			'query' => Deliveries::find(),
			'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Deliveries model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$lines = [];
		
		$sql = "Select * from deliverylines
				JOIN purchaselines ON purchaselines.PurchaseLineID = deliverylines.PurchaseLineID 
				LEFT JOIN purchases ON purchases.PurchaseID = purchaselines.PurchaseID
				LEFT JOIN product ON product.ProductID = purchaselines.ProductID
				LEFT JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				WHERE DeliveryID = $id";
				
		$data = PurchaseLines::findBySql($sql)->asArray()->all();
		
		$sql = "SELECT PurchaseLineID, sum(DeliveredQuantity) as Delivered FROM deliveries
					JOIN deliverylines ON deliverylines.DeliveryID = deliveries.DeliveryID
					WHERE PurchaseID = " . $model->PurchaseID . "
					GROUP BY PurchaseLineID";
				
		$delivered = ArrayHelper::map(DeliveryLines::findBySql($sql)->asArray()->all(), 'PurchaseLineID', 'Delivered') ;
		$currentdelivery = ArrayHelper::index(DeliveryLines::find()->where(['DeliveryID'=> $id])->asArray()->all(), 'PurchaseLineID');
		for ($x = 0; $x < count($data); $x++) { 			
			$PurchaseLineID = $data[$x]['PurchaseLineID'];
			$_line = new DeliveryLines();
			$_line->DeliveryLineID = isset($currentdelivery[$PurchaseLineID]) ? $currentdelivery[$PurchaseLineID]['DeliveryLineID'] : '';//$data[$x]['DeliveryLineID'];
			$_line->DeliveredQuantity = isset($currentdelivery[$PurchaseLineID]) ? $currentdelivery[$PurchaseLineID]['DeliveredQuantity'] : 0;//$data[$x]['DeliveredQuantity'];
			$_line->PurchaseLineID = $data[$x]['PurchaseLineID'];
			$lines[$x] = $_line;
		}
	
		$purchases = ArrayHelper::map(Purchases::find()->joinWith('suppliers')->all(), 'PurchaseID', 'PurchaseName');
	
		return $this->render('view', [
			'model' => $model, 'purchases' => $purchases, 
		'lines' => $lines, 'data' => $data, 'delivered' => $delivered
		]);
	}

	/**
	 * Creates a new Deliveries model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Deliveries();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['update', 'id' => $model->DeliveryID]);
		} else {
			$purchases = ArrayHelper::map(Purchases::find()->joinWith('suppliers')->where(['Closed'=>0])->orderBy('PurchaseID DESC')->all(), 'PurchaseID', 'PurchaseName');
			return $this->render('create', [
					'model' => $model, 'purchases' => $purchases,
			]);
		}
	}

	/**
	 * Updates an existing Deliveries model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			
			//print_r($params); exit;
			$lines = $params['DeliveryLines'];
			
			foreach ($lines as $key => $line) {
				if ($line['DeliveryLineID'] == '') {
					$_line = new DeliveryLines();
					$_line->DeliveryID = $id;
					$_line->PurchaseLineID = $line['PurchaseLineID'];
				} else {
					$_line = DeliveryLines::findOne($line['DeliveryLineID']);
				}
				$_line->DeliveredQuantity = isset($line['DeliveredQuantity']) ? $line['DeliveredQuantity'] : 0;					
				$_line->save();
			}
			return $this->redirect(['view', 'id' => $model->DeliveryID]);
		} else {
			$sql = "Select *, ProductName, UsageUnitName FROM purchaselines 
					LEFT JOIN purchases ON purchases.PurchaseID = purchaselines.PurchaseID
					LEFT JOIN product ON product.ProductID = purchaselines.ProductID
					LEFT JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
					WHERE purchaselines.PurchaseID =" . $model->PurchaseID;
			
			$data = PurchaseLines::findBySql($sql)->asArray()->all();
			
			$sql = "SELECT PurchaseLineID, sum(DeliveredQuantity) as Delivered FROM deliveries
					JOIN deliverylines ON deliverylines.DeliveryID = deliveries.DeliveryID
					WHERE PurchaseID = " . $model->PurchaseID . " GROUP BY PurchaseLineID";
					
			$delivered = ArrayHelper::map(DeliveryLines::findBySql($sql)->asArray()->all(), 'PurchaseLineID', 'Delivered');
			
			$currentdelivery = ArrayHelper::index(DeliveryLines::find()->where(['DeliveryID'=> $id])->asArray()->all(), 'PurchaseLineID');
			$lines = [];
			for ($x = 0; $x < count($data); $x++) { 
				$PurchaseLineID = $data[$x]['PurchaseLineID'];
				$_line = new DeliveryLines();
				$_line->DeliveryLineID = isset($currentdelivery[$PurchaseLineID]) ? $currentdelivery[$PurchaseLineID]['DeliveryLineID'] : '';//$data[$x]['DeliveryLineID'];
				$_line->DeliveredQuantity = isset($currentdelivery[$PurchaseLineID]) ? $currentdelivery[$PurchaseLineID]['DeliveredQuantity'] : 0;//$data[$x]['DeliveredQuantity'];
				$_line->PurchaseLineID = $data[$x]['PurchaseLineID'];
				$lines[$x] = $_line;
			}
			
			$purchases = ArrayHelper::map(Purchases::find()->joinWith('suppliers')->all(), 'PurchaseID', 'PurchaseName');
			return $this->render('update', [
				'model' => $model,
				'purchases' => $purchases,
				'lines' => $lines,
				'data' => $data,
				'delivered' => $delivered
			]);
		}
	}

	public function actionPost($id)
	{
		// check for missing products
		$lines = DeliveryLines::find()->where(['DeliveredQuantity'=> 0])->orWhere('DeliveredQuantity is null')->count();
		// echo $lines; exit;
		if ($lines > 0) {
			$model = $this->findModel($id);
		
			$model->Posted = 1;
			$model->PostingDate = date('Y-m-d h:i:s');
			if ($model->save()) {
				// Make adjustment to the stock
				$lines = DeliveryLines::find()->joinWith('purchaseLines')->where(['DeliveryID'=> $id])->all();
				foreach ($lines as $key => $line)
				{
					$stock = new StockAdjustment();
					$stock->AdjustmentTypeID = 2;
					$stock->AdjustmentID = $id;
					$stock->Quantity = $line->DeliveredQuantity;
					$stock->ProductID = $line->purchaseLines->ProductID;
					if ($stock->save()) {

					} else {
						
					}
				}
			} 
		} else {
			Yii::$app->session->setFlash('error', "Items delivered is zero");
		}
		return $this->redirect(['view', 'id' => $id]);
	}

	/**
	 * Deletes an existing Deliveries model.
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
	 * Finds the Deliveries model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Deliveries the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Deliveries::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionGrn($id)
	{
		$Title = 'Goods Received Note';
		$model = Deliveries::find()->joinWith('purchases')
								->joinWith('purchases.suppliers')
								->where(['DeliveryID' => $id])->one();
		
/* 		$sql = "SELECT temp.*, ProductName, DeliveryLineID, UsageUnitName FROM 
				(
				SELECT purchaselines.*, DeliveredQuantity, DeliveryID, DeliveryLineID FROM deliverylines
				RIGHT JOIN purchaselines ON purchaselines.PurchaseLineID = deliverylines.PurchaseLineID
				) temp 
				LEFT JOIN purchases ON purchases.PurchaseID = temp.PurchaseID
				LEFT JOIN product ON product.ProductID = temp.ProductID
				LEFT JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				WHERE temp.DeliveryID =" . $model->DeliveryID; */

			$sql = "SELECT temp.*, ProductName, DeliveryLineID, UsageUnitName FROM 
				(
				SELECT purchaselines.*, DeliveredQuantity, DeliveryID, DeliveryLineID FROM deliverylines
				RIGHT JOIN purchaselines ON purchaselines.PurchaseLineID = deliverylines.PurchaseLineID
				) temp 
				LEFT JOIN purchases ON purchases.PurchaseID = temp.PurchaseID
				LEFT JOIN product ON product.ProductID = temp.ProductID
				LEFT JOIN usageunit ON usageunit.UsageUnitID = product.UsageUnitID
				WHERE temp.DeliveryID =" . $model->DeliveryID;
				
		$data = PurchaseLines::findBySql($sql)->asArray()->all();
		
		// $sql = "SELECT PurchaseLineID, sum(DeliveredQuantity) as Delivered FROM deliverylines
		// 		WHERE DeliveryID = $id
		// 		GROUP BY PurchaseLineID";
				
		// $delivered = ArrayHelper::map(DeliveryLines::findBySql($sql)->asArray()->all(), 'PurchaseLineID', 'Delivered') ;

		$sql = "SELECT PurchaseLineID, sum(DeliveredQuantity) as Delivered FROM deliveries
		JOIN deliverylines ON deliverylines.DeliveryID = deliveries.DeliveryID
		WHERE PurchaseID = " . $model->PurchaseID . "
		GROUP BY PurchaseLineID";
	
		$delivered = ArrayHelper::map(DeliveryLines::findBySql($sql)->asArray()->all(), 'PurchaseLineID', 'Delivered') ;
		
		$lines = [];
		for ($x = 0; $x < count($data); $x++) { 
			$_line = new DeliveryLines();
			$_line->DeliveryLineID = $data[$x]['DeliveryLineID'];
			$_line->DeliveredQuantity = $data[$x]['DeliveredQuantity'];
			$_line->PurchaseLineID = $data[$x]['PurchaseLineID'];
			$lines[$x] = $_line;
		}
		$company = Company::find()->where(['CompanyID'=>1])->one();
		$purchases = ArrayHelper::map(Purchases::find()->joinWith('suppliers')->all(), 'PurchaseID', 'PurchaseName');

		
		$content = $this->renderPartial('grn', ['model' => $model, 'purchases' => $purchases, 
			'lines' => $lines, 'data' => $data, 'delivered' => $delivered, 'company' => $company														  
															]);
		//exit;
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
		]);
	}	
}
