<?php

namespace backend\controllers;

use Yii;
use app\models\BankAccounts;
use app\models\BankBranches;
use app\models\Banks;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BankAccountsController implements the CRUD actions for BankAccounts model.
 */
class BankAccountsController extends Controller
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
	 * Lists all BankAccounts models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => BankAccounts::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
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
		return $this->render('view', [
			'model' => $this->findModel($id),
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
		$bankBranches = []; //ArrayHelper::map(BankBranches::find()->all(), 'BankBranchID', 'BankBranchName');
		return $this->render('create', [
			'model' => $model,
			'banks' => $banks,
			'bankBranches' => $bankBranches
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

		return $this->render('update', [
			'model' => $model,
			'banks' => $banks,
			'bankBranches' => $bankBranches
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
