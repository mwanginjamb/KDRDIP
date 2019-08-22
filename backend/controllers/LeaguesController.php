<?php

namespace backend\controllers;

use Yii;
use app\models\Leagues;
use app\models\Regions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * LeaguesController implements the CRUD actions for Leagues model.
 */
class LeaguesController extends Controller
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
	 * Lists all Leagues models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index', [
			'model' => Leagues::find()->joinWith('regions')->all(),
		]);
	}

	/**
	 * Displays a single Leagues model.
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
	 * Creates a new Leagues model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Leagues();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->LeagueID]);
			return $this->redirect(['index']);
		}

		$regions = ArrayHelper::map(Regions::find()->all(), 'RegionID', 'RegionName');
		
		return $this->render('create', [
			'model' => $model,
			'regions' => $regions,
		]);
	}

	/**
	 * Updates an existing Leagues model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// return $this->redirect(['view', 'id' => $model->LeagueID]);
			return $this->redirect(['index']);
		}

		$regions = ArrayHelper::map(Regions::find()->all(), 'RegionID', 'RegionName');

		return $this->render('update', [
			'model' => $model,
			'regions' => $regions,
		]);
	}

	/**
	 * Deletes an existing Leagues model.
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
	 * Finds the Leagues model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Leagues the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Leagues::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
