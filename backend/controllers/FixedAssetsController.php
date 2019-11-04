<?php

namespace backend\controllers;

use Yii;
use app\models\FixedAssets;
use app\models\Projects;
use app\models\Employees;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * FixedAssetsController implements the CRUD actions for FixedAssets model.
 */
class FixedAssetsController extends Controller
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
	 * Lists all FixedAssets models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => FixedAssets::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single FixedAssets model.
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
	 * Creates a new FixedAssets model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new FixedAssets();
		$model->CreatedBy = Yii::$app->user->identity->UserID;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->FixedAssetID]);
		}

		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$employees = ArrayHelper::map(Employees::find()->all(), 'EmployeeID', 'EmployeeName');

		return $this->render('create', [
			'model' => $model,
			'projects' => $projects,
			'employees' => $employees,
		]);
	}

	/**
	 * Updates an existing FixedAssets model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->FixedAssetID]);
		}

		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$employees = ArrayHelper::map(Employees::find()->all(), 'EmployeeID', 'EmployeeName');
		
		return $this->render('update', [
			'model' => $model,
			'projects' => $projects,
			'employees' => $employees,
		]);
	}

	/**
	 * Deletes an existing FixedAssets model.
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
	 * Finds the FixedAssets model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return FixedAssets the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = FixedAssets::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
