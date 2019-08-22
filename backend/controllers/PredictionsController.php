<?php

namespace backend\controllers;

use Yii;
use app\models\Predictions;
use app\models\Leagues;
use app\models\Regions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PredictionsController implements the CRUD actions for Predictions model.
 */
class PredictionsController extends Controller
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
	 * Lists all Predictions models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		return $this->render('index', [
			'model' => Predictions::find()->joinWith('regions')->joinWith('leagues')->all(),
		]);
	}

	/**
	 * Displays a single Predictions model.
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
	 * Creates a new Predictions model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Predictions();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->PredictionID]);
			return $this->redirect(['index']);
		}

		$regions = ArrayHelper::map(Regions::find()->all(), 'RegionID', 'RegionName');
		$leagues = ArrayHelper::map(Leagues::find()->all(), 'LeagueID', 'LeagueName');

		return $this->render('create', [
			'model' => $model,
			'regions' => $regions,
			'leagues' => $leagues,
		]);
	}

	/**
	 * Updates an existing Predictions model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->PredictionID]);
			return $this->redirect(['index']);
		}

		$regions = ArrayHelper::map(Regions::find()->all(), 'RegionID', 'RegionName');
		$leagues = ArrayHelper::map(Leagues::find()->all(), 'LeagueID', 'LeagueName');

		return $this->render('update', [
			'model' => $model,
			'regions' => $regions,
			'leagues' => $leagues,
		]);
	}

	/**
	 * Deletes an existing Predictions model.
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
	 * Finds the Predictions model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Predictions the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Predictions::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
