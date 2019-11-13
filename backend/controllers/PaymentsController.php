<?php

namespace backend\controllers;

use Yii;
use app\models\Payments;
use app\models\Search;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentsController implements the CRUD actions for Payments model.
 */
class PaymentsController extends Controller
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
	 * Lists all Payments models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchfor = [1 => 'ID', 2 => 'Supplier', 3 => 'RefNumber', 4 => 'Amount'];
		$search = new Search();
		$params = Yii::$app->request->post();
		$where = '';
		if (!empty($params)) {
			if ($params['Search']['searchfor'] == 1) {
				$searchstring = $params['Search']['searchstring'];
				$where = "PaymentID = '$searchstring'";
			} elseif ($params['Search']['searchfor'] == 2) {
				$searchstring = $params['Search']['searchstring'];
				$where = ""; // "suppliers like '%$searchstring%' || MiddleName like '%$searchstring%' || LastName like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 3) {
				$searchstring = $params['Search']['searchstring'];
				$where = "RefNumber like '%$searchstring%'";
			} elseif ($params['Search']['searchfor'] == 4) {
				$searchstring = $params['Search']['searchstring'];
				$where = "Amount like '%$searchstring%'";
			}
			$search->searchfor = $params['Search']['searchfor'];
			$search->searchstring = $params['Search']['searchstring'];
		}

		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find()->where($where),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider, 'search' => $search, 'searchfor' => $searchfor,
		]);
/* 		$dataProvider = new ActiveDataProvider([
			'query' => Payments::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]); */
	}

	/**
	 * Displays a single Payments model.
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
	 * Creates a new Payments model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Payments();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->PaymentID]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Payments model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->PaymentID]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Payments model.
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
	 * Finds the Payments model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Payments the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Payments::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
