<?php

namespace backend\controllers;

use Yii;
use app\models\LipwBeneficiaries;
use app\models\BankBranches;
use app\models\LipwBeneficiaryTypes;
use app\models\Banks;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;

/**
 * LipwBeneficiariesController implements the CRUD actions for LipwBeneficiaries model.
 */
class LipwBeneficiariesController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(98);

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
					'delete' => ['POST', 'GET'],
				],
			],
		];
	}

	/**
	 * Lists all LipwBeneficiaries models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$hId = isset(Yii::$app->request->get()['hId']) ? Yii::$app->request->get()['hId'] : 0;

		$dataProvider = new ActiveDataProvider([
			'query' => LipwBeneficiaries::find()->andWhere(['HouseholdID' => $hId]),
		]);

		return $this->renderPartial('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'hId' => $hId,
		]);
	}

	/**
	 * Displays a single LipwBeneficiaries model.
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
	 * Creates a new LipwBeneficiaries model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$hId = isset(Yii::$app->request->get()['hId']) ? Yii::$app->request->get()['hId'] : 0;

		$model = new LipwBeneficiaries();
		$model->HouseholdID = $hId;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'hId' => $model->HouseholdID]);
		}

		$banks = ArrayHelper::map(Banks::find()->all(), 'BankID', 'BankName');
		$bankBranches = ArrayHelper::map(BankBranches::find()->andWhere(['BankID' => $model->BankID])->all(), 'BankBranchID', 'BankBranchName');
		$beneficiaries = ArrayHelper::map(LipwBeneficiaries::find()->andWhere(['BeneficiaryTypeID' => 1])->all(), 'BeneficiaryID', 'BeneficiaryName');
		$beneficiaryTypes = ArrayHelper::map(LipwBeneficiaryTypes::find()->all(), 'BeneficiaryTypeID', 'BeneficiaryTypeName');
		
		$gender = ['M' => 'Male', 'F' => 'Female'];

		return $this->renderPartial('create', [
			'model' => $model,
			'rights' => $this->rights,
			'hId' => $hId,
			'banks' => $banks,
			'bankBranches' => $bankBranches,
			'beneficiaries' => $beneficiaries,
			'gender' => $gender,
			'beneficiaryTypes' => $beneficiaryTypes
		]);
	}

	/**
	 * Updates an existing LipwBeneficiaries model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		// echo $id; exit;
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'hId' => $model->HouseholdID]);
		}

		$banks = ArrayHelper::map(Banks::find()->all(), 'BankID', 'BankName');
		$bankBranches = ArrayHelper::map(BankBranches::find()->andWhere(['BankID' => $model->BankID])->all(), 'BankBranchID', 'BankBranchName');
		$beneficiaries = ArrayHelper::map(LipwBeneficiaries::find()->andWhere(['BeneficiaryTypeID' => 1])->andWhere("BeneficiaryID <> $id")->all(), 'BeneficiaryID', 'BeneficiaryName');
		$beneficiaryTypes = ArrayHelper::map(LipwBeneficiaryTypes::find()->all(), 'BeneficiaryTypeID', 'BeneficiaryTypeName');
		$gender = ['M' => 'Male', 'F' => 'Female'];

		return $this->renderPartial('update', [
			'model' => $model,
			'rights' => $this->rights,
			'banks' => $banks,
			'bankBranches' => $bankBranches,
			'beneficiaries' => $beneficiaries,
			'gender' => $gender,
			'beneficiaryTypes' => $beneficiaryTypes,
		]);
	}

	/**
	 * Deletes an existing LipwBeneficiaries model.
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
	 * Finds the LipwBeneficiaries model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return LipwBeneficiaries the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = LipwBeneficiaries::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
