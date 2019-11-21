<?php

namespace backend\controllers;

use Yii;
use app\models\Banks;
use app\models\BankBranches;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BanksController implements the CRUD actions for Banks model.
 */
class BanksController extends Controller
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
	 * Lists all Banks models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Banks::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Banks model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$bankBranches = new ActiveDataProvider([
			'query' => BankBranches::find()->where(['BankID'=> $id]),
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'bankBranches' => $bankBranches
		]);
	}

	/**
	 * Creates a new Banks model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Banks();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveBankBranches(Yii::$app->request->post()['BankBranches'], $model);

			return $this->redirect(['view', 'id' => $model->BankID]);
		}

		for ($x = 0; $x <= 4; $x++) {
			$bankBranches[$x] = new BankBranches();
		}

		return $this->render('create', [
			'model' => $model,
			'bankBranches' => $bankBranches
		]);
	}

	/**
	 * Updates an existing Banks model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$bankBranches = BankBranches::find()->where(['BankID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveBankBranches(Yii::$app->request->post()['BankBranches'], $model);
			return $this->redirect(['view', 'id' => $model->BankID]);
		}

		for ($x = count($bankBranches); $x <= 4; $x++) {
			$bankBranches[$x] = new BankBranches();
		}

		return $this->render('update', [
			'model' => $model,
			'bankBranches' => $bankBranches
		]);
	}

	/**
	 * Deletes an existing Banks model.
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
	 * Finds the Banks model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Banks the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Banks::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	private static function saveBankBranches($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['BankBranchID'] == '') {
				if (trim($column['BankBranchName']) != '') {
					$_column = new BankBranches();
					$_column->BankID = $model->BankID;
					$_column->BankBranchName = $column['BankBranchName'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = BankBranches::findOne($column['BankBranchID']);
				$_column->BankBranchName = $column['BankBranchName'];
				$_column->save();
			}
		}
	}
}