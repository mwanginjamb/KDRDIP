<?php

namespace backend\controllers;

use Yii;
use app\models\Indicators;
use app\models\ProjectTeams;
use app\models\Projects;
use app\models\Accounts;
use app\models\ActivityBudget;
use app\models\Components;
use app\models\UnitsOfMeasure;
use app\models\SubComponents;
use app\models\Activities;
use app\models\Employees;
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

		$project = Projects::findOne($pid);
		$componentID = !empty($project) ? $project->ComponentID : 0;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveIndicatorTargets(Yii::$app->request->post()['IndicatorTargets'], $model);
			$this->saveActivities(Yii::$app->request->post()['Activities'], $model);
			
			return $this->redirect(['projects/view', 'id' => $pid]);
		}

		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');
		$subComponents = ArrayHelper::map(SubComponents::find()->where(['componentID' => $componentID])->all(), 'SubComponentID', 'SubComponentName');
		$projectTeams = ArrayHelper::map(ProjectTeams::find()->all(), 'ProjectTeamID', 'ProjectTeamName');
		$employees = ArrayHelper::map(Employees::find()->all(), 'EmployeeID', 'EmployeeName');

		$sql = "SELECT Temp.*, reportingperiods.ReportingPeriodID as RPID, ReportingPeriodName FROM (
			SELECT * FROM indicatortargets
			WHERE IndicatorID = 0
			) as Temp 
			right JOIN reportingperiods ON reportingperiods.ReportingPeriodID = Temp.ReportingPeriodID where ProjectID = $pid";

		// $indicatorTargets = IndicatorTargets::find()->where(['IndicatorID' => $id])->all();
		$indicatorTargets = [];
		$indicatorTargetsArr = IndicatorTargets::findBySql($sql)->asArray()->all();
		foreach ($indicatorTargetsArr as $key => $target) {
			$indicatorTargets[$key] = new IndicatorTargets();
			$indicatorTargets[$key]->IndicatorTargetID = $target['IndicatorTargetID'];
			$indicatorTargets[$key]->IndicatorTargetName = $target['IndicatorTargetName'];
			$indicatorTargets[$key]->IndicatorID = $target['IndicatorID'];
			$indicatorTargets[$key]->ReportingPeriodID = $target['RPID'];
			$indicatorTargets[$key]->Target = $target['Target'];
			$indicatorTargets[$key]->ReportingPeriodName = $target['ReportingPeriodName'];
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
			'activities' => $activities,
			'employees' => $employees
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
		$project = Projects::findOne($pid);
		$ComponentID = (!empty($project)) ? $project->ComponentID : 0;

		$subComponent = SubComponents::findOne($model->SubComponentID);
		if ($subComponent) {
			$model->ComponentID = $subComponent->ComponentID;
		}

		$sql = "SELECT Temp.*, reportingperiods.ReportingPeriodID as RPID, ReportingPeriodName FROM (
					SELECT * FROM indicatortargets
					WHERE IndicatorID = $id
					) as Temp
					right JOIN reportingperiods ON reportingperiods.ReportingPeriodID = Temp.ReportingPeriodID 
					where ProjectID = $pid";

		$indicatorTargetsArr = IndicatorTargets::findBySql($sql)->asArray()->all();
		$activities = Activities::find()->where(['IndicatorID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {	
			$this->saveIndicatorTargets(Yii::$app->request->post()['IndicatorTargets'], $model);
			$this->saveActivities(Yii::$app->request->post()['Activities'], $model);

			return $this->redirect(['projects/view', 'id' => $pid]);
		}
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		$unitsOfMeasure = ArrayHelper::map(UnitsOfMeasure::find()->all(), 'UnitOfMeasureID', 'UnitOfMeasureName');
		$subComponents = ArrayHelper::map(SubComponents::find()->where(['ComponentID' => $ComponentID])->all(), 'SubComponentID', 'SubComponentName');
		$projectTeams = ArrayHelper::map(ProjectTeams::find()->all(), 'ProjectTeamID', 'ProjectTeamName');
		$employees = ArrayHelper::map(Employees::find()->all(), 'EmployeeID', 'EmployeeName');

		for ($x = count($activities); $x <= 10; $x++) {
			$activities[$x] = new Activities();
		}

		foreach ($indicatorTargetsArr as $key => $target) {
			$indicatorTargets[$key] = new IndicatorTargets();
			$indicatorTargets[$key]->IndicatorTargetID = $target['IndicatorTargetID'];
			$indicatorTargets[$key]->IndicatorTargetName = $target['IndicatorTargetName'];
			$indicatorTargets[$key]->IndicatorID = $target['IndicatorID'];
			$indicatorTargets[$key]->ReportingPeriodID = $target['RPID'];
			$indicatorTargets[$key]->Target = $target['Target'];
			$indicatorTargets[$key]->ReportingPeriodName = $target['ReportingPeriodName'];
		}

		return $this->render('update', [
			'model' => $model,
			'components' => $components,
			'subComponents' => $subComponents,
			'unitsOfMeasure' => $unitsOfMeasure,
			'projectTeams' => $projectTeams,
			'indicatorTargets' => $indicatorTargets,
			'activities' => $activities,
			'employees' => $employees
		]);
	}

	/**
	 * Deletes an existing Indicators model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id, $pid)
	{
		$this->findModel($id)->delete();

		// return $this->redirect(['index']);
		return $this->redirect(['projects/view', 'id' => $pid]);
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

	public function actionActivityBudget($id)
	{

		if (Yii::$app->request->post()) {
			// print_r(Yii::$app->request->post()); exit;
			$this->saveActivityBudget(Yii::$app->request->post()['ActivityBudget'], $id);
			return '';
			// exit;
		}

		$budget = ActivityBudget::find()->where(['ActivityID' => $id])->all();
		$accounts = ArrayHelper::map(Accounts::find()->all(), 'AccountID', 'AccountName');

		for ($x = count($budget); $x <= 5; $x++) {
			$budget[$x] = new ActivityBudget();
		}
		// print('<pre>');
		// print_r($budget); exit;

		return $this->renderPartial('activity-budget', [
			'budget' => $budget,
			'accounts' => $accounts,
			'id' => $id
		]);
	}

	private static function saveIndicatorTargets($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['IndicatorTargetID'] == '') {
				if (trim($column['Target']) != '') {
					$_column = new IndicatorTargets();
					$_column->IndicatorID = $model->IndicatorID;
					$_column->IndicatorTargetName = $column['IndicatorTargetName'];
					$_column->Target = $column['Target'];
					$_column->ReportingPeriodID = $column['ReportingPeriodID'];
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
					$_column->ResponsibilityID = $column['ResponsibilityID'];
					$_column->StartDate = $column['StartDate'];
					$_column->EndDate = $column['EndDate'];
					$_column->ActualStartDate = $column['ActualStartDate'];
					$_column->ActualEndDate = $column['ActualEndDate'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = Activities::findOne($column['ActivityID']);
				$_column->ActivityName = $column['ActivityName'];
				$_column->ResponsibilityID = $column['ResponsibilityID'];
				$_column->StartDate = $column['StartDate'];
				$_column->EndDate = $column['EndDate'];
				$_column->ActualStartDate = $column['ActualStartDate'];
				$_column->ActualEndDate = $column['ActualEndDate'];
				$_column->save();
			}
		}
	}

	private static function saveActivityBudget($columns, $ActivityID)
	{
		// print_r($columns); exit;
		foreach ($columns as $key => $column) {
			if ($column['ActivityBudgetID'] == '') {
				if (trim($column['Description']) != '') {
					$_column = new ActivityBudget();
					$_column->ActivityID = $ActivityID;
					$_column->Description = $column['Description'];
					$_column->AccountID = $column['AccountID'];
					$_column->Amount = $column['Amount'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ActivityBudget::findOne($column['ActivityBudgetID']);
				$_column->Description = $column['Description'];
				$_column->AccountID = $column['AccountID'];
				$_column->Amount = $column['Amount'];
				$_column->save();
			}
		}
	}
}
