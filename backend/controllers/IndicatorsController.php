<?php

namespace backend\controllers;

use Yii;
use app\models\Indicators;
use app\models\ProjectTeams;
use app\models\Components;
use app\models\UnitsOfMeasure;
use app\models\SubComponents;
use app\models\Activities;
use app\models\IndicatorTargets;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * IndicatorsController implements the CRUD actions for Indicators model.
 */
class IndicatorsController extends Controller
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
	 * Lists all Indicators models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Indicators::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Indicators model.
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
	 * Creates a new Indicators model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($pid)
	{
		$model = new Indicators();
		$model->ProjectID = $pid;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveIndicatorTargets(Yii::$app->request->post()['IndicatorTargets'], $model);
			$this->saveActivities(Yii::$app->request->post()['Activities'], $model);
			
			return $this->redirect(['projects/view', 'id' => $pid]);
		}

		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');
		$subComponents = ArrayHelper::map(SubComponents::find()->all(), 'SubComponentID', 'SubComponentName');
		$projectTeams = ArrayHelper::map(ProjectTeams::find()->all(), 'ProjectTeamID', 'ProjectTeamName');

		for ($x = 0; $x <= 4; $x++) {
			$indicatorTargets[$x] = new IndicatorTargets();
		}

		for ($x = 0; $x <= 9; $x++) {
			$activities[$x] = new Activities();
		}

		return $this->render('create', [
			'model' => $model,
			'components' => $components,
			'subComponents' => $subComponents,
			'unitsOfMeasure' => $unitsOfMeasure,
			'projectTeams' => $projectTeams,
			'indicatorTargets' => $indicatorTargets,
			'activities' => $activities
		]);
	}

	/**
	 * Updates an existing Indicators model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id, $pid)
	{
		$model = $this->findModel($id);
		$subComponent = SubComponents::findOne($model->SubComponentID);
		if ($subComponent) {
			$model->ComponentID = $subComponent->ComponentID;
		}
		 
		$indicatorTargets = IndicatorTargets::find()->where(['IndicatorID' => $id])->all();
		$activities = Activities::find()->where(['IndicatorID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {			
			$this->saveIndicatorTargets(Yii::$app->request->post()['IndicatorTargets'], $model);
			$this->saveActivities(Yii::$app->request->post()['Activities'], $model);

			return $this->redirect(['projects/view', 'id' => $pid]);
		}
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');
		$subComponents = ArrayHelper::map(SubComponents::find()->all(), 'SubComponentID', 'SubComponentName');
		$projectTeams = ArrayHelper::map(ProjectTeams::find()->all(), 'ProjectTeamID', 'ProjectTeamName');

		for ($x = count($activities); $x <= 10; $x++) {
			$activities[$x] = new Activities();
		}

		for ($x = count($indicatorTargets); $x <= 5; $x++) {
			$indicatorTargets[$x] = new IndicatorTargets();
		}

		return $this->render('update', [
			'model' => $model,
			'components' => $components,
			'subComponents' => $subComponents,
			'unitsOfMeasure' => $unitsOfMeasure,
			'projectTeams' => $projectTeams,
			'indicatorTargets' => $indicatorTargets,
			'activities' => $activities
		]);
	}

	/**
	 * Deletes an existing Indicators model.
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
	 * Finds the Indicators model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Indicators the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Indicators::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	private static function saveIndicatorTargets($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['IndicatorTargetID'] == '') {
				if (trim($column['IndicatorTargetName']) != '') {
					$_column = new IndicatorTargets();
					$_column->IndicatorID = $model->IndicatorID;
					$_column->IndicatorTargetName = $column['IndicatorTargetName'];
					$_column->Target = $column['Target'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = IndicatorTargets::findOne($column['IndicatorTargetID']);
				$_column->IndicatorTargetName = $column['IndicatorTargetName'];
				$_column->Target = $column['Target'];
				$_column->save();
			}
		}
	}

	private static function saveActivities($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ActivityID'] == '') {
				if (trim($column['ActivityName']) != '') {
					$_column = new Activities();
					$_column->IndicatorID = $model->IndicatorID;
					$_column->ActivityName = $column['ActivityName'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = Activities::findOne($column['ActivityID']);
				$_column->ActivityName = $column['ActivityName'];
				$_column->save();
			}
		}
	}
}
