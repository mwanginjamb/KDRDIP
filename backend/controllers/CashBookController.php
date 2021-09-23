<?php

namespace backend\controllers;

use Yii;
use app\models\CashBook;
use app\models\BankAccounts;
use app\models\Counties;
use app\models\Projects;
use app\models\ProjectDisbursement;
use app\models\Communities;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * CashBookController implements the CRUD actions for CashBook model.
 */
class CashBookController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(11);

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
	 * Lists all CashBook models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => CashBook::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Displays a single CashBook model.
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
	 * Creates a new CashBook model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($baid)
	{
		$model = new CashBook();
		$model->Date = date('Y-m-d');
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$params = Yii::$app->request->post()['CashBook'];
			
			$model = new CashBook();
			$model->CreatedBy = Yii::$app->user->identity->UserID;
			$model->Date = $params['Date'];
			$model->TypeID = 1;
			$model->BankAccountID = $baid;
			$model->AccountID = $params['AccountID'];
			$model->Description = $params['Description'];
			$model->DocumentReference = $params['DocumentReference'];
			$model->ProjectID = $params['ProjectID'];
			$model->CommunityID = $params['CommunityID'];
			$model->CountyID = $params['CountyID'];
			$model->ProjectDisbursementID = $params['ProjectDisbursementID'];
			$model->Credit = $params['Amount'];
			$model->Amount = $params['Amount'];
			$model->save();

			$model = new CashBook();
			$model->CreatedBy = Yii::$app->user->identity->UserID;
			$model->Date = $params['Date'];
			$model->TypeID = 1;
			$model->BankAccountID = $params['AccountID'];
			$model->AccountID = $baid;
			$model->Description = $params['Description'];
			$model->DocumentReference = $params['DocumentReference'];
			$model->ProjectID = $params['ProjectID'];
			$model->CommunityID = $params['CommunityID'];
			$model->CountyID = $params['CountyID'];
			$model->ProjectDisbursementID = $params['ProjectDisbursementID'];
			$model->Debit = $params['Amount'];
			$model->Amount = $params['Amount'];
			$model->save();

			return $this->redirect(['bank-accounts/view', 'id' => $baid]);
		}

		// $bankAccounts = ArrayHelper::map(BankAccounts::find()->where(['CountyID' => $model->CountyID, 'CommunityID' => $model->CommunityID])->all(), 'BankAccountID', 'AccountName');
		$bankAccounts = ArrayHelper::map(BankAccounts::find()->where(['CommunityID' => $model->CommunityID])->all(), 'BankAccountID', 'AccountName');
		$projects = ArrayHelper::map(Projects::find()->where(['CountyID' => $model->CountyID, 'CommunityID' => $model->CommunityID])->all(), 'ProjectID', 'ProjectName');
		$communities = ArrayHelper::map(Communities::find()->where(['CountyID' => $model->CountyID])->all(), 'CommunityID', 'CommunityName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$projectDisbursements = ArrayHelper::map(ProjectDisbursement::find()->where(['ProjectID' => $model->ProjectID])->all(), 'ProjectDisbursementID', 'Year');;
		return $this->render('create', [
			'model' => $model,
			'bankAccounts' => $bankAccounts,
			'projects' => $projects,
			'counties' => $counties,
			'communities' => $communities,
			'rights' => $this->rights,
			'projectDisbursements' => $projectDisbursements,
			'baid' => $baid,
		]);
	}

	/**
	 * Updates an existing CashBook model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id, $baid)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['bank-accounts/view', 'id' => $baid]);
		}
		$bankAccounts = ArrayHelper::map(BankAccounts::find()->all(), 'BankAccountID', 'AccountName');
		return $this->render('update', [
			'model' => $model,
			'bankAccounts' => $bankAccounts,
			'rights' => $this->rights,
		]);
	}

	/**
	 * Deletes an existing CashBook model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id, $baid)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['bank-accounts/view', 'id' => $baid]);
	}

	/**
	 * Finds the CashBook model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CashBook the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = CashBook::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionProjects($communityId, $countyId)
	{
		$model = Projects::find()->where(['CountyID' => $countyId, 'CommunityID' => $communityId])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->ProjectID . "'>" . $item->ProjectName . '</option>';
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionBankAccounts($communityId, $countyId)
	{
		// $model = BankAccounts::find()->where(['CountyID' => $countyId, 'CommunityID' => $communityId])->all();
		$model = BankAccounts::find()->where(['CommunityID' => $communityId])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->BankAccountID . "'>" . $item->AccountName . '</option>';
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}
}
