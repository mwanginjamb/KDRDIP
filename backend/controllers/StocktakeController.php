<?php

namespace backend\controllers;

use Yii;
use app\models\StockTake;
use app\models\Product;
use app\models\ApprovalNotes;
use app\models\ApprovalStatus;
use app\models\StockTakeLines;
use app\models\StockAdjustment;
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
 * StockTakeController implements the CRUD actions for StockTake model.
 */
class StocktakeController extends Controller
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
			array_push($rightsArray, 'index', 'view', 'update', 'approval', 'approvallist', 'submit');
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
			'only' => ['index', 'view', 'create', 'update', 'delete', 'approval', 'approvallist', 'submit'],
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
	 * Lists all StockTake models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$UserID = Yii::$app->user->identity->UserID;
	
		$dataProvider = new ActiveDataProvider([
			'query' => StockTake::find()->where(['stocktake.CreatedBy' => $UserID]),
			'sort'=> ['defaultOrder' => ['CreatedDate'=>SORT_DESC]],
		]);
		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single StockTake model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => StockTakeLines::find()->joinWith('product')
									->joinWith('product.productcategory')
									->joinWith('product.usageunit')
									->where(['StockTakeID' => $id]),
		]);
	
		return $this->render('view', [
			'model' => $this->findModel($id), 'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new StockTake model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new StockTake();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$sql = "SELECT ProductID, Sum(Quantity) as Total FROM stockadjustment
					GROUP BY ProductID";
			$products = Product::findBySql($sql)->asArray()->all();
			
			foreach ($products as $key => $product)
			{
				$line = new StockTakeLines();
				$line->ProductID = $product['ProductID'];
				$line->StockTakeID = $model->StockTakeID;
				$line->CurrentStock = $product['Total'];
				$line->save();
			}
			
			return $this->redirect(['view', 'id' => $model->StockTakeID]);
		} 

		$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName') ;
		return $this->render('create', [
				'model' => $model,
				'stores' => $stores
		]);
	}

	/**
	 * Updates an existing StockTake model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$params = Yii::$app->request->post();
			$lines = $params['StockTakeLines'];
			
			foreach ($lines as $key => $line)
			{
				$_line = StockTakeLines::findOne($line['StockTakeLineID']);
				$_line->PhysicalStock = $line['PhysicalStock'];
				$_line->save();

				//print_r($_line->getErrors());
			}
		
			return $this->redirect(['view', 'id' => $model->StockTakeID]);
		} 
		$stores = ArrayHelper::map(Stores::find()->all(), 'StoreID', 'StoreName') ;
		$lines = StockTakeLines::find()->joinWith('product')
								->joinWith('product.productcategory')
								->joinWith('product.usageunit')
								->where(['StockTakeID' => $id])->all();
		return $this->render('update', [
			'model' => $model, 
			'lines' => $lines,
			'stores' => $stores
		]);
	}

	/**
	 * Deletes an existing StockTake model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionApproval($id, $option)
	{
		$identity = Yii::$app->user->identity;
		$UserID = $identity->UserID;
		
		$params = Yii::$app->request->post();
		$dataProvider = new ActiveDataProvider([
				'query' => StockTakeLines::find()->joinWith('product')->where(['StockTakeID'=> $id]),
			]);
		$model = $this->findModel($id);

		$notes = new ApprovalNotes();
	
		if (Yii::$app->request->post()) {
			if ($params['option']==1 && isset($params['Approve']))
			{
				$model->ApprovalStatusID = 2;
			} else if ($params['option']==2 && isset($params['Approve']))
			{
				$model->ApprovalStatusID = 3;

				$model->PostingDate = date('Y-m-d h:i:s');
				$model->Posted = 1;
				$model->ApprovedBy  = $UserID;
				$model->ApprovalDate = date('Y-m-d h:i:s');
			}
			
			if (isset($params['Reject']))
			{
				$model->ApprovalStatusID = 4;
			}
		}

		if (Yii::$app->request->post() && $model->save()) {
			$params = Yii::$app->request->post();
			
			// Add Notes to the notes table
			$notes->Note = $params['ApprovalNotes']['Note'];
			$notes->ApprovalStatusID = $model->ApprovalStatusID;
			$notes->ApprovalTypeID = 4;
			$notes->ApprovalID = $id;
			$notes->CreatedBy = $UserID;
			$notes->save();
			
			// Make adjustment to the stock
			if ($model->ApprovalStatusID==3)
			{
				$lines = StockTakeLines::find()->where(['StockTakeID'=> $id])->all();
				foreach ($lines as $key => $line)
				{
					$stock = new StockAdjustment();
					$stock->AdjustmentTypeID = 1;
					$stock->AdjustmentID = $id;
					$stock->Quantity = $line->PhysicalStock-$line->CurrentStock;
					$stock->ProductID = $line->ProductID;
					$stock->save();
				}
			}
			if ($model->ApprovalStatusID == 2)
			{
				$result = UsersController::sendEmailNotification(14); 
			}
			return $this->redirect(['approvallist', 'option'=> $option]);
		} else {
			$approvalstatus = ArrayHelper::map(ApprovalStatus::find()->where("ApprovalStatusID > 1")->all(), 'ApprovalStatusID', 'ApprovalStatusName');
			$detailmodel = StockTake::find()->where(['StockTakeID'=> $id])->joinWith('approvalstatus')->one();
			return $this->render('approval', [
				'model' => $model,'detailmodel' => $detailmodel, 'dataProvider' => $dataProvider, 
				'approvalstatus' => $approvalstatus, 'notes' => $notes, 'option' => $option,
			]);
		}
	}
	public function actionApprovallist($option)
	{
		$StatusID = ($option == 1) ? 1 : 2;
	
		$dataProvider = new ActiveDataProvider([
			'query' => StockTake::find()->joinWith('users')->where(['ApprovalStatusID'=>$StatusID]),
		]);

		return $this->render('approvallist', [
			'dataProvider' => $dataProvider, 'option' => $option,
		]);
	}

	public function actionSubmit($id)
	{
		$model = $this->findModel($id);
		$model->ApprovalStatusID = 1;
		if ($model->save())
		{
			$result = UsersController::sendEmailNotification(30); 
			return $this->redirect(['view', 'id' => $model->StockTakeID]);
		}
	}

	/**
	 * Finds the StockTake model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return StockTake the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = StockTake::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
