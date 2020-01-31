<?php

namespace backend\controllers;

use Yii;
use app\models\StoreRequisition;
use app\models\StoreRequisitionLine;
use app\models\Product;
use app\models\Users;
use app\models\Stores;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * StoreRequisitionController implements the CRUD actions for StoreRequisition model.
 */
class StoreRequisitionController extends Controller
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
	 * Lists all StoreRequisition models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => StoreRequisition::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single StoreRequisition model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => StoreRequisitionLine::find()->joinWith('product')->where(['StoreRequisitionID'=> $id]),
		]);

		$model = StoreRequisition::find()->where(['StoreRequisitionID'=> $id])->joinWith('approvalstatus')->one();

		return $this->render('view', [
			'model' => $model, 'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new StoreRequisition model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		
		$model = new StoreRequisition();
		$model->CreatedBy = $UserID;
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$StoreRequisitionID = $model->StoreRequisitionID;
			
			$params = Yii::$app->request->post();
			$lines = isset($params['StoreRequisitionLine']) ? $params['RequisitionLine'] : [];
			
			foreach ($lines as $key => $line) {
				if ($line['ProductID'] != '') {
					$_line = new StoreRequisitionLine();
					$_line->StoreRequisitionID = $StoreRequisitionID;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->CreatedBy = $UserID;
					$_line->save();
					//print_r($_line->getErrors());
				}
			}
			//exit;
			return $this->redirect(['update', 'id' => $model->StoreRequisitionID]);
		}
		
		$products = ArrayHelper::map(Product::find()->all(), 'ProductID', 'ProductName');
		$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName');
		$users = Users::findOne($UserID);
		for ($x = 0; $x <= 9; $x++) {
			$lines[$x] = new StoreRequisitionLine();
		}

		return $this->render('create', [
				'model' => $model, 'lines' => $lines, 'products' => $products, 'stores' => $stores, 'users' => $users,
		]);
	}

	/**
	 * Updates an existing StoreRequisition model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
	
		$lines = StoreRequisitionLine::find()->where(['StoreRequisitionID' => $id])->all();
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['StoreRequisitionLine'];
			
			foreach ($lines as $key => $line) {
				//print_r($lines);exit;
					
				if ($line['RequisitionLineID'] == '') {
					if ($line['ProductID'] != '') {
						$_line = new StoreRequisitionLine();
						$_line->StoreRequisitionID = $id;
						$_line->ProductID = $line['ProductID'];
						$_line->Quantity = $line['Quantity'];
						$_line->Description = $line['Description'];
						$_line->CreatedBy = $UserID;
						$_line->save();
						//print_r($_line->getErrors());
					}
				} else {
					$_line = StoreRequisitionLine::findOne($line['RequisitionLineID']);
					$_line->StoreRequisitionID = $id;
					$_line->ProductID = $line['ProductID'];
					$_line->Quantity = $line['Quantity'];
					$_line->Description = $line['Description'];
					$_line->save();
				}
				
				//print_r($_line->getErrors());
			}
		
			return $this->redirect(['view', 'id' => $model->StoreRequisitionID]);
		}

		$StoreID = $model->StoreID;
		$products = ArrayHelper::map(Product::find()->joinWith('productcategory')->where(['StoreID'=>$model->StoreID])->all(), 'ProductID', 'ProductName');
		$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName');
		$users = Users::findOne($model->CreatedBy);
		$modelcount = count($lines);
		for ($x = $modelcount; $x <= 9; $x++) {
			$lines[$x] = new StoreRequisitionLine();
		}
	
		return $this->render('update', [
				'model' => $model, 'lines' => $lines, 'products' => $products, 'stores' => $stores,  'users' => $users,
		]);
	}

	/**
	 * Deletes an existing StoreRequisition model.
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
	 * Finds the StoreRequisition model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return StoreRequisition the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = StoreRequisition::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		if ($model->save()) {
			$result = UsersController::sendEmailNotification(27);
			return $this->redirect(['view', 'id' => $model->StoreRequisitionID]);
		}
	}

	public function actionGetfields($id, $StoreID)
	{
		$UserID = Yii::$app->user->identity->UserID;
		
		$products = ArrayHelper::map(Product::find()->joinWith('productcategory')->where(['StoreID'=>$StoreID])->all(), 'ProductID', 'ProductName');

		$row = $id -1;		
		$Fields[0] = $id.'<input type="hidden" id="requisitionline-'.$row.'-requisitionlineid" class="form-control" name="RequisitionLine['.$row.'][RequisitionLineID]" type="hidden">';
		
		$str = '<select id="requisitionline-'.$row.'-productid" class="form-control-min" name="RequisitionLine['.$row.'][ProductID]"><option value=""></option>';
		
		foreach ($products as $key => $value)
		{
			$str .= '<option value="'.$key.'">'.$value.'</option>';
		}		
		$str .= '</select>';

		$Fields[1] = $str;
		$Fields[2] = '<input type="text" id="requisitionline-'.$row.'-quantity" class="form-control-min" name="RequisitionLine['.$row.'][Quantity]">';
		$Fields[3] = '<input type="text" id="requisitionline-'.$row.'-description" class="form-control-min" name="RequisitionLine['.$row.'][Description]">';

		$json = json_encode($Fields);
		echo $json;
	}
}
