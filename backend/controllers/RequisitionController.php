<?php

namespace backend\controllers;

use Yii;
use app\models\Requisition;
use app\models\RequisitionLine;
use app\models\QuotationTypes;
use app\models\QuotationProducts;
use app\models\Quotation;
use app\models\Accounts;
use app\models\Product;
use app\models\Projects;
use app\models\Users;
use app\models\Stores;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use yii\filters\AccessControl;
use backend\controllers\RightsController;
use backend\controllers\UsersController;

/**
 * RequisitionController implements the CRUD actions for Requisition model.
 */
class RequisitionController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
		'access' => [
					'class' => AccessControl::className(),
					'only' => ['index', 'view', 'create', 'update', 'delete', 'submit'],
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
							'actions' => ['index', 'view', 'create', 'update', 'delete', 'submit'],
							'roles' => ['@'],
						],
					],
			],
			'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
				'submit' => ['POST'],
					],
			],
		];
	}

	/**
	 * Lists all Requisition models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$UserID = Yii::$app->user->identity->UserID;
		
/* 		$dataProvider = new ActiveDataProvider([
			'query' => Requisition::find()->joinWith('users')->where(['requisition.CreatedBy' => $UserID]),
			'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]); */
		$dataProvider = new ActiveDataProvider([
			'query' => Requisition::find()->joinWith('users'),
			'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Requisition model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => RequisitionLine::find()->joinWith('product')->where(['RequisitionID'=> $id]),
		]);
		$model = Requisition::find()->where(['RequisitionID'=> $id])->joinWith('approvalstatus')->one();
		return $this->render('view', [
			'model' => $model, 'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Requisition model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		
		$model = new Requisition();
		$model->CreatedBy = $UserID;
		$lines = [];

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$RequisitionID = $model->RequisitionID;
			
			$params = Yii::$app->request->post();
			$lines = isset($params['RequisitionLine']) ? $params['RequisitionLine'] : [];
			
			foreach ($lines as $key => $line) {
				if ($line['ProductID'] != '') {
					$_line = new RequisitionLine();
					$_line->RequisitionID = $RequisitionID;
					$_line->ProductID = ($line['QuotationTypeID'] == 1) ? $line['ProductID'] : 0;
					$_line->AccountID = ($line['QuotationTypeID'] != 1) ? $line['ProductID'] : 0;
					$_line->ProjectID = isset($line['ProjectID']) ? $line['ProjectID'] : 0;
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->QuotationTypeID = $line['QuotationTypeID'];
					$_line->save();
				}
			}
			//exit;
			return $this->redirect(['update', 'id' => $model->RequisitionID]);
		}

		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$accounts = ArrayHelper::map(Accounts::find()->all(), 'AccountID', 'AccountName');
		$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName');
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$users = Users::findOne($UserID);
		$quotationTypes = ArrayHelper::map(QuotationTypes::find()->all(), 'QuotationTypeID', 'QuotationTypeName');
		$products[1] = $products;
		$products[2] = $accounts;

		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			$requisitionLine = isset($params['RequisitionLine']) ? $params['RequisitionLine'] : [];
			foreach ($requisitionLine as $x => $line) {
				$lines[$x] = new RequisitionLine();
				$lines[$x]->RequisitionLineID = $line['RequisitionLineID'];
            $lines[$x]->QuotationTypeID = $line['QuotationTypeID'];
            $lines[$x]->ProductID = $line['ProductID'];
            $lines[$x]->ProjectID = $line['ProjectID'];
            $lines[$x]->Quantity = $line['Quantity'];
            $lines[$x]->Description = $line['Description'];
			}
		}

		for ($x = count($lines); $x <= 9; $x++) { 
			$lines[$x] = new RequisitionLine();
		}

		/* if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			$lines = isset($params['RequisitionLine']) ? $params['RequisitionLine'] : [];
		} else {
			for ($x = 0; $x <= 9; $x++) {
				$lines[$x] = new RequisitionLine();
			}
		} */

		return $this->render('create', [
			'model' => $model,
			'lines' => $lines,
			'products' => $products,
			'stores' => $stores,
			'users' => $users,
			'quotationTypes' => $quotationTypes,
			'projects' => $projects
		]);
	}

	/**
	 * Updates an existing Requisition model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		
		$lines = RequisitionLine::find()->where(['RequisitionID' => $id])->all();

		foreach ($lines as $key => $line) {
			// $lines[$key] = new QuotationProducts();
			// $lines[$key] = $line;
			if ($line->QuotationTypeID != 1) {
				$lines[$key]->ProductID = $line->AccountID;
			}
		}
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['RequisitionLine'];
			
			foreach ($lines as $key => $line) {					
				if ($line['RequisitionLineID'] == '') {
					if ($line['ProductID'] != '') {
						$_line = new RequisitionLine();
						$_line->RequisitionID = $id;
						$_line->ProductID = ($line['QuotationTypeID'] == 1) ? $line['ProductID'] : 0;
						$_line->AccountID = ($line['QuotationTypeID'] != 1) ? $line['ProductID'] : 0;
						$_line->ProjectID = isset($line['ProjectID']) ? $line['ProjectID'] : 0;
						$_line->Quantity = $line['Quantity'];
						$_line->Description = $line['Description'];
						$_line->QuotationTypeID = $line['QuotationTypeID'];
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else {
					$_line = RequisitionLine::findOne($line['RequisitionLineID']);
					$_line->RequisitionID = $id;
					$_line->ProductID = ($line['QuotationTypeID'] == 1) ? $line['ProductID'] : 0;
					$_line->AccountID = ($line['QuotationTypeID'] != 1) ? $line['ProductID'] : 0;
					$_line->ProjectID = isset($line['ProjectID']) ? $line['ProjectID'] : 0;
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->QuotationTypeID = $line['QuotationTypeID'];
					$_line->save();
				}
			}
			return $this->redirect(['view', 'id' => $model->RequisitionID]);
		}

		$StoreID = $model->StoreID;
		// $products = ArrayHelper::map(Product::find()->joinWith('productcategory')->where(['StoreID'=>$model->StoreID])->all(), 'ProductID', 'ProductName');
		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName');
		$accounts = ArrayHelper::map(Accounts::find()->all(), 'AccountID', 'AccountName');
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$quotationTypes = ArrayHelper::map(QuotationTypes::find()->all(), 'QuotationTypeID', 'QuotationTypeName');
		$users = Users::findOne($model->CreatedBy);

		$products[1] = $products;
		$products[2] = $accounts;
		$products[3] = $accounts;

		// print '<pre>';
		// print_r($lines); exit;
		// print_r($products); exit;
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			$requisitionLine = isset($params['RequisitionLine']) ? $params['RequisitionLine'] : [];
			foreach ($requisitionLine as $x => $line) {
				$lines[$x] = new RequisitionLine();
				$lines[$x]->RequisitionLineID = $line['RequisitionLineID'];
            $lines[$x]->QuotationTypeID = $line['QuotationTypeID'];
            $lines[$x]->ProductID = $line['ProductID'];
            $lines[$x]->ProjectID = $line['ProjectID'];
            $lines[$x]->Quantity = $line['Quantity'];
            $lines[$x]->Description = $line['Description'];
			}
		}

		for ($x = count($lines); $x <= 9; $x++) { 
			$lines[$x] = new RequisitionLine();
		}
		/* print '<pre>';
		print_r($lines); exit; */
		
		return $this->render('update', [
			'model' => $model,
			'lines' => $lines,
			'products' => $products,
			'stores' => $stores,
			'users' => $users,
			'quotationTypes' => $quotationTypes,
			'projects' => $projects
		]);

	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		if ($model->save()) {
			$result = UsersController::sendEmailNotification(27); 
			return $this->redirect(['view', 'id' => $model->RequisitionID]);
		}
	}

	public function actionGetfields($id, $StoreID)
	{
		$UserID = Yii::$app->user->identity->UserID;
		$quotationTypes = ArrayHelper::map(QuotationTypes::find()->all(), 'QuotationTypeID', 'QuotationTypeName');
		
		$products = ArrayHelper::map(Product::find()->joinWith('productcategory')->where(['StoreID'=>$StoreID])->all(), 'ProductID', 'ProductName');

		$row = $id -1;		
		$Fields[0] = $id . '<input type="hidden" id="requisitionline-'.$row.'-requisitionlineid" class="form-control" name="RequisitionLine['.$row.'][RequisitionLineID]" type="hidden">';
		
		$str = '<select id="requisitionline-' . $row . '-quotationtypeid" class="form-control" name="RequisitionLine[' . $row . '][QuotationTypeID]" onchange="
						$.post( &quot;/mande/backend/web/quotation/get-types?id=&quot;+$(this).val()+&quot;&amp;TypeID=&quot;+$(&quot;#requisitionline-' . $row . '-quotationtypeid&quot;).val(), 
						function( data ) {
							$( &quot;select#requisitionline-' . $row . '-productid&quot; ).html( data );
						});
					">
					<option value=""></option>';
		foreach ($quotationTypes as $key => $value) {
			$str .= '<option value="' . $key . '">' . $value . '</option>';
		}
		$str .= '</select>';

		$str1 = '<select id="requisitionline-' . $row . '-productid" class="form-control" name="RequisitionLine[' . $row . '][ProductID]">
					<option value=""></option>
					</select>';

		$Fields[1] = $str;
		$Fields[2] = $str1;
		$Fields[3] = '<input type="text" id="requisitionline-' . $row . '-quantity" class="form-control" name="RequisitionLine[' . $row . '][Quantity]">';
		$Fields[4] = '<input type="text" id="requisitionline-' . $row . '-description" class="form-control" name="RequisitionLine[' . $row . '][Description]">';
		
		$json = json_encode($Fields);
		echo $json;
	}

	/**
	 * Deletes an existing Requisition model.
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
	 * Finds the Requisition model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Requisition the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Requisition::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
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

	public function actionCreateQuotation($id)
	{
		$requisition = Requisition::findOne($id);
		$lines = RequisitionLine::find()->where(['RequisitionID' => $id])->all();
		$model = new Quotation();
		$model->Description = $requisition->Description;
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->RequisitionID = $id;
		if ($model->save()) {
			foreach ($lines as $key => $line) {
				$quotationLines = new QuotationProducts();
				$quotationLines->QuotationID = $model->QuotationID;
				$quotationLines->ProductID = $line->ProductID;
				$quotationLines->Quantity = $line->Quantity;
				$quotationLines->QuotationTypeID = $line->QuotationTypeID;
				$quotationLines->AccountID = $line->AccountID;
				$quotationLines->save();
			}
			return $this->redirect(['quotation/view', 'id' => $model->QuotationID]);
		}
	}
}
