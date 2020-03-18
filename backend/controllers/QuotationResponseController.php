<?php

namespace backend\controllers;

use Yii;
use app\models\QuotationResponse;
use app\models\QuotationResponseLines;
use app\models\Quotation;
use app\models\Suppliers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * QuotationResponseController implements the CRUD actions for QuotationResponse model.
 */
class QuotationResponseController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(42);

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
	 * Lists all QuotationResponse models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => QuotationResponse::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single QuotationResponse model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new QuotationResponse model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($qid, $sid)
	{
		$quotationResponse = QuotationResponse::findOne(['SupplierID' => $sid, 'QuotationID' => $qid]);

		if (!empty($quotationResponse)) {
			return $this->redirect(['update', 'id' => $quotationResponse->QuotationResponseID]);
		}

		$model = new QuotationResponse();
		$model->SupplierID = $sid;
		$model->QuotationID = $qid;
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->ResponseDate = date('Y-m-d');

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			
			foreach ($params['QuotationResponseLines'] as $x => $product) {
				$_line = new QuotationResponseLines();
				$_line->QuotationResponseID = $model->QuotationResponseID;
				$_line->QuotationProductID = $product['QuotationProductID'];
				$_line->UnitPrice = $product['UnitPrice'];
				$_line->CreatedBy = Yii::$app->user->identity->UserID;
				$_line->save();
			}

			// return $this->redirect(['view', 'id' => $model->QuotationResponseID]);
			return $this->redirect(['quotation/view', 'id' => $model->QuotationID]);
		}

		$quotation = Quotation::findOne($qid);
		$supplier = Suppliers::findOne($sid);

		$sql = "Select * FROM (
					Select * from quotationresponselines
					WHERE QuotationResponseID = 0
					) temp 
					right JOIN (select * from quotationproducts Where QuotationID = $qid) Products 
					ON Products.QuotationProductID = temp.QuotationProductID";

		$quotationResponseLines = QuotationResponseLines::findBySql($sql)->asArray()->all();
		foreach ($quotationResponseLines as $key => $product) {
			$lines[$key] = new QuotationResponseLines();
			$lines[$key]->QuotationResponseLineID = $product['QuotationResponseLineID'];
			$lines[$key]->QuotationResponseID = $product['QuotationResponseID'];
			$lines[$key]->QuotationProductID = $product['ProductID'];
			$lines[$key]->UnitPrice = $product['UnitPrice'];
			$lines[$key]->ProductID = $product['ProductID'];
			$lines[$key]->Quantity = $product['Quantity'];
		}
		
		return $this->render('create', [
			'model' => $model,
			'lines' => $lines,
			'quotation' => $quotation,
			'supplier' => $supplier,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing QuotationResponse model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$qid = $model->QuotationID;
		$quotationResponseID = $model->QuotationResponseID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();

			foreach ($params['QuotationResponseLines'] as $x => $product) {
				if ($product['QuotationResponseLineID'] == '') {
					$_line = new QuotationResponseLines();
					$_line->QuotationResponseID = $model->QuotationResponseID;
					$_line->QuotationProductID = $product['QuotationProductID'];
					$_line->UnitPrice = $product['UnitPrice'];
					$_line->CreatedBy = Yii::$app->user->identity->UserID;
					$_line->save();
				} else {
					$_line = QuotationResponseLines::findOne($product['QuotationResponseLineID']);
					/* $_line->QuotationResponseID = $model->QuotationResponseID;
					$_line->QuotationProductID = $product['QuotationProductID']; */
					$_line->UnitPrice = $product['UnitPrice'];
					$_line->save();
				}
			}
			// return $this->redirect(['view', 'id' => $model->QuotationResponseID]);
			return $this->redirect(['quotation/view', 'id' => $model->QuotationID]);
		}

		$quotation = Quotation::findOne($qid);
		$supplier = Suppliers::findOne($model->SupplierID);

		$sql = "Select * FROM (
			Select * from quotationresponselines
			WHERE QuotationResponseID = $quotationResponseID
			) temp 
			right JOIN (select * from quotationproducts Where QuotationID = $qid) Products 
			ON Products.QuotationProductID = temp.QuotationProductID";
			
		$quotationResponseLines = QuotationResponseLines::findBySql($sql)->asArray()->all();

		foreach ($quotationResponseLines as $key => $product) {
			$lines[$key] = new QuotationResponseLines();
			$lines[$key]->QuotationResponseLineID = $product['QuotationResponseLineID'];
			$lines[$key]->QuotationResponseID = $product['QuotationResponseID'];
			$lines[$key]->QuotationProductID = $product['QuotationProductID'];
			$lines[$key]->UnitPrice = $product['UnitPrice'];
			$lines[$key]->ProductID = $product['ProductID'];
			$lines[$key]->Quantity = $product['Quantity'];
		}

		return $this->render('update', [
			'model' => $model,
			'lines' => $lines,
			'quotation' => $quotation,
			'supplier' => $supplier,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing QuotationResponse model.
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
	 * Finds the QuotationResponse model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return QuotationResponse the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = QuotationResponse::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
