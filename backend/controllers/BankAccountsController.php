<?php

namespace backend\controllers;

use Yii;
use app\models\BankAccounts;
use app\models\BankBranches;
use app\models\Banks;
use app\models\Counties;
use app\models\Communities;
use app\models\BankTypes;
use app\models\CashBook;
use app\models\BankAccountFilter;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * BankAccountsController implements the CRUD actions for BankAccounts model.
 */
class BankAccountsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(5);

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
	 * Lists all BankAccounts models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$model = new BankAccountFilter();
		$where = 'Deleted = 0';
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->CountyID) {
				$where .= ' AND CountyID = ' . $model->CountyID;
			}
			if ($model->CommunityID) {
				$where .= ' AND CommunityID = ' . $model->CommunityID;
			}
		}
		$dataProvider = new ActiveDataProvider([
			'query' => BankAccounts::find()->where($where),
		]);	

		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$communities = ArrayHelper::map(Communities::find()->orderBy('CommunityName')->all(), 'CommunityID', 'CommunityName');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'model' => $model,
			'counties' => $counties,
			'communities' => $communities
		]);
	}

	/**
	 * Displays a single BankAccounts model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$cashBook = new ActiveDataProvider([
			'query' => CashBook::find()->where(['BankAccountID'=> $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'cashBook' => $cashBook,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Creates a new BankAccounts model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new BankAccounts();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->BankAccountID]);
		}
		$banks = ArrayHelper::map(Banks::find()->all(), 'BankID', 'BankName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$communities = ArrayHelper::map(Communities::find()->all(), 'CommunityID', 'CommunityName');
		$bankTypes = ArrayHelper::map(BankTypes::find()->all(), 'BankTypeID', 'BankTypeName');

		$bankBranches = [];
		return $this->render('create', [
			'model' => $model,
			'banks' => $banks,
			'bankBranches' => $bankBranches,
			'counties' => $counties,
			'communities' => $communities,
			'bankTypes' => $bankTypes,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Updates an existing BankAccounts model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->BankAccountID]);
		}
		$banks = ArrayHelper::map(Banks::find()->all(), 'BankID', 'BankName');
		$bankBranches = ArrayHelper::map(BankBranches::find()->where(['BankID' => $model->BankID ])->all(), 'BankBranchID', 'BankBranchName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$communities = ArrayHelper::map(Communities::find()->all(), 'CommunityID', 'CommunityName');
		$bankTypes = ArrayHelper::map(BankTypes::find()->all(), 'BankTypeID', 'BankTypeName');

		return $this->render('update', [
			'model' => $model,
			'banks' => $banks,
			'bankBranches' => $bankBranches,
			'counties' => $counties,
			'communities' => $communities,
			'bankTypes' => $bankTypes,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing BankAccounts model.
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
	 * Finds the BankAccounts model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return BankAccounts the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = BankAccounts::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionBranches($id)
	{
		$model = BankBranches::find()->where(['BankID' => $id])->all();
			
		if (!empty($model)) {
			foreach ($model as $item) {
				echo "<option value='" . $item->BankBranchID . "'>" . $item->BankBranchName . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}
}
