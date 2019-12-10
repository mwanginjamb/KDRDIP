<?php

namespace backend\controllers;

use Yii;
use app\models\Projects;
use app\models\ActivityBudget;
use app\models\ProjectStatus;
use app\models\FundingSources;
use app\models\ProjectFunding;
use app\models\ProjectRisk;
use app\models\RiskRating;
use app\models\RiskLikelihood;
use app\models\ProjectDisbursement;
use app\models\ProjectSafeguardingPolicies;
use app\models\SafeguardingPolicies;
use app\models\ProjectBeneficiaries;
use app\models\ProjectTeams;
use app\models\ProjectNotes;
use app\models\ProjectUnits;
use app\models\ProjectRoles;
use app\models\ReportingPeriods;
use app\models\Counties;
use app\models\SubCounties;
use app\models\Indicators;
use app\models\IndicatorTargets;
use app\models\IndicatorActuals;
use app\models\Components;
use app\models\Activities;
use app\models\Budget;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProjectsController implements the CRUD actions for projects model.
 */
class ProjectsController extends Controller
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
	 * Lists all projects models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		if (isset(Yii::$app->request->get()['cid']) && Yii::$app->request->get()['cid'] != '') { 
			$projects = Projects::find()->where(['ComponentID' => Yii::$app->request->get()['cid']]);
			$cid = Yii::$app->request->get()['cid'];
		} else {
			$projects = Projects::find();
			$cid = '';
		}
		$dataProvider = new ActiveDataProvider([
			'query' => $projects,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'cid' => $cid
		]);
	}

	/**
	 * Displays a single projects model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		if (Yii::$app->request->post()) {
			$params = Yii::$app->request->post();
			foreach ($params as $key => $value) {
				$keyArray = explode('_', $key);
				if (count($keyArray) == 2) {
					$IndicatorID = $keyArray[0];
					$ReportingPeriodID = $keyArray[1];

					$actual = IndicatorActuals::findOne(['IndicatorID' => $IndicatorID, 'ReportingPeriodID' => $ReportingPeriodID]); 
					if (empty($actual)) {
						$actual = new IndicatorActuals();
						$actual->IndicatorID = $IndicatorID;
						$actual->ReportingPeriodID = $ReportingPeriodID;
						$actual->Actual = $value;
						$actual->save();
					} else {
						$actual->Actual = $value;
						$actual->save();
					}
				}
			}
		}
		$projectFunding = new ActiveDataProvider([
			'query' => ProjectFunding::find()->where(['ProjectID'=> $id]),
		]);

		$projectRisk = new ActiveDataProvider([
			'query' => ProjectRisk::find()->where(['ProjectID'=> $id]),
		]);

		$projectDisbursement = new ActiveDataProvider([
			'query' => ProjectDisbursement::find()->where(['ProjectID'=> $id]),
		]);

		$projectSafeguardingPolicies = new ActiveDataProvider([
			'query' => ProjectSafeguardingPolicies::find()->where(['ProjectID'=> $id]),
		]);

		$projectBeneficiaries = new ActiveDataProvider([
			'query' => ProjectBeneficiaries::find()->where(['ProjectID'=> $id]),
		]);

		$projectTeams = new ActiveDataProvider([
			'query' => ProjectTeams::find()->where(['ProjectID'=> $id]),
		]);

		$projectNotes = new ActiveDataProvider([
			'query' => ProjectNotes::find()->where(['ProjectID'=> $id]),
		]);

		$indicators = new ActiveDataProvider([
			'query' => Indicators::find()->joinWith('unitsOfMeasure')->where(['ProjectID'=> $id]),
		]);

		$sql = "Select * FROM activitybudget 
		LEFT JOIN activities ON activities.ActivityID = activitybudget.ActivityID
		LEFT JOIN indicators ON indicators.IndicatorID = activities.IndicatorID
		LEFT JOIN accounts on accounts.AccountID = activitybudget.AccountID
		WHERE ProjectID = $id";

		$budgetProvider = new ActiveDataProvider([
			'query' => ActivityBudget::find()->joinWith('activities')->joinWith('activities.indicators')->where(['ProjectID' => $id]),
		]);

		$reportingPeriods = new ActiveDataProvider([
			'query' => ReportingPeriods::find()->where(['ProjectID'=> $id]),
		]);

		$activitiesArray = Activities::find()->joinWith('indicators')->where(['indicators.ProjectID' => $id])->all();
		$activities = ArrayHelper::index($activitiesArray, null, 'IndicatorID');
		$indicatorTargets = IndicatorTargets::find()->joinWith('indicators')
									->where(['indicators.ProjectID' => $id])->asArray()->all();
		$targets = ArrayHelper::index($indicatorTargets, 'ReportingPeriodID', [function ($element) {
															return $element['IndicatorID'];
													}]);

		$indicatorActuals = IndicatorActuals::find()->joinWith('indicators')
													->where(['indicators.ProjectID' => $id])->asArray()->all();
		$actuals = ArrayHelper::index($indicatorActuals, 'ReportingPeriodID', [function ($element) {
																			return $element['IndicatorID'];
																	}]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'projectFunding' => $projectFunding,
			'projectRisk' => $projectRisk,
			'projectDisbursement' => $projectDisbursement,
			'projectSafeguardingPolicies' => $projectSafeguardingPolicies,
			'projectBeneficiaries' => $projectBeneficiaries,
			'projectTeams' => $projectTeams,
			'projectNotes' => $projectNotes,
			'indicators' => $indicators,
			'budgetProvider' => $budgetProvider,
			'reportingPeriods' => $reportingPeriods,
			'activities' => $activities,
			'targets' => $targets,
			'actuals' => $actuals
		]);
	}

	/**
	 * Creates a new projects model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new projects();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		if (isset(Yii::$app->request->get()['cid']) && Yii::$app->request->get()['cid'] != '') {
			$model->ComponentID = Yii::$app->request->get()['cid'];
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveProjectFunding(Yii::$app->request->post()['ProjectFunding'], $model);
			$this->saveProjectRisk(Yii::$app->request->post()['ProjectRisk'], $model);
			$this->saveprojectDisbursement(Yii::$app->request->post()['ProjectDisbursement'], $model);
			$this->saveprojectSafeguardingPolicies(Yii::$app->request->post()['ProjectSafeguardingPolicies'], $model);
			$this->saveprojectBeneficiaries(Yii::$app->request->post()['ProjectBeneficiaries'], $model);
			$this->saveprojectNotes(Yii::$app->request->post()['ProjectNotes'], $model);
			$this->saveprojectTeams(Yii::$app->request->post()['ProjectTeams'], $model);
			$this->saveReportingPeriods(Yii::$app->request->post()['ReportingPeriods'], $model);

			return $this->redirect(['view', 'id' => $model->ProjectID]);
		}
		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$projectStatus = ArrayHelper::map(ProjectStatus::find()->all(), 'ProjectStatusID', 'ProjectStatusName');
		$fundingSources = ArrayHelper::map(FundingSources::find()->all(), 'FundingSourceID', 'FundingSourceName');
		$riskRating = ArrayHelper::map(RiskRating::find()->all(), 'RiskRatingID', 'RiskRatingName');
		$safeguardingpolicies = ArrayHelper::map(SafeguardingPolicies::find()->all(), 'SafeguardingPolicyID', 'SafeguardingPolicyName');
		$projectUnits = ArrayHelper::map(projectUnits::find()->all(), 'ProjectUnitID', 'ProjectUnitName');
		$projectRoles = ArrayHelper::map(projectRoles::find()->all(), 'ProjectRoleID', 'ProjectRoleName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->all(), 'SubCountyID', 'SubCountyName', 'CountyID');
		$riskLikelihood = ArrayHelper::map(RiskLikelihood::find()->all(), 'RiskLikelihoodID', 'RiskLikelihoodName');
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
	
		for ($x = 0; $x <= 4; $x++) {
			$projectRisk[$x] = new ProjectRisk();
		}

		for ($x = 0; $x <= 4; $x++) {
			$projectFunding[$x] = new ProjectFunding();
		}

		for ($x = 0; $x <= 4; $x++) {
			$projectDisbursement[$x] = new ProjectDisbursement();
		}

		for ($x = 0; $x <= 4; $x++) {
			$projectSafeguardingPolicies[$x] = new ProjectSafeguardingPolicies();
		}

		for ($x = 0; $x <= 4; $x++) {
			$projectBeneficiaries[$x] = new ProjectBeneficiaries();
		}

		for ($x = 0; $x <= 4; $x++) {
			$projectNotes[$x] = new ProjectNotes();
		}

		for ($x = 0; $x <= 4; $x++) {
			$projectTeams[$x] = new ProjectTeams();
		}

		for ($x = 0; $x <= 4; $x++) {
			$reportingPeriods[$x] = new ReportingPeriods();
		}

		return $this->render('create', [
			'model' => $model,
			'projects' => $projects,
			'projectStatus' => $projectStatus,
			'fundingSources' => $fundingSources,
			'projectFunding' => $projectFunding,
			'projectRisk' => $projectRisk,
			'riskRating' => $riskRating,
			'projectDisbursement' => $projectDisbursement,
			'projectSafeguardingPolicies' => $projectSafeguardingPolicies,
			'safeguardingpolicies' => $safeguardingpolicies,
			'projectBeneficiaries' => $projectBeneficiaries,
			'projectNotes' => $projectNotes,
			'projectUnits' => $projectUnits,
			'projectRoles' => $projectRoles,
			'projectTeams' => $projectTeams,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'riskLikelihood' => $riskLikelihood,
			'components' => $components,
			'reportingPeriods' => $reportingPeriods
		]);
	}

	/**
	 * Updates an existing projects model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$projectFunding = ProjectFunding::find()->where(['ProjectID' => $id])->all();
		$projectRisk = ProjectRisk::find()->where(['ProjectID' => $id])->all();
		$projectDisbursement = ProjectDisbursement::find()->where(['ProjectID' => $id])->all();
		$projectSafeguardingPolicies = ProjectSafeguardingPolicies::find()->where(['ProjectID' => $id])->all();
		$projectBeneficiaries = ProjectBeneficiaries::find()->where(['ProjectID' => $id])->all();
		$projectNotes = ProjectNotes::find()->where(['ProjectID' => $id])->all();
		$projectTeams = ProjectTeams::find()->where(['ProjectID' => $id])->all();
		$reportingPeriods = ReportingPeriods::find()->where(['ProjectID' => $id])->all();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveProjectFunding(Yii::$app->request->post()['ProjectFunding'], $model);
			$this->saveProjectRisk(Yii::$app->request->post()['ProjectRisk'], $model);
			$this->saveprojectDisbursement(Yii::$app->request->post()['ProjectDisbursement'], $model);
			$this->saveprojectSafeguardingPolicies(Yii::$app->request->post()['ProjectSafeguardingPolicies'], $model);
			$this->saveprojectBeneficiaries(Yii::$app->request->post()['ProjectBeneficiaries'], $model);
			$this->saveprojectNotes(Yii::$app->request->post()['ProjectNotes'], $model);
			$this->saveprojectTeams(Yii::$app->request->post()['ProjectTeams'], $model);
			$this->saveReportingPeriods(Yii::$app->request->post()['ReportingPeriods'], $model);
			
			return $this->redirect(['view', 'id' => $model->ProjectID]);
		}

		$projects = ArrayHelper::map(Projects::find()->all(), 'ProjectID', 'ProjectName');
		$projectStatus = ArrayHelper::map(ProjectStatus::find()->all(), 'ProjectStatusID', 'ProjectStatusName');
		$fundingSources = ArrayHelper::map(FundingSources::find()->all(), 'FundingSourceID', 'FundingSourceName');
		$riskRating = ArrayHelper::map(RiskRating::find()->all(), 'RiskRatingID', 'RiskRatingName');
		$safeguardingpolicies = ArrayHelper::map(SafeguardingPolicies::find()->all(), 'SafeguardingPolicyID', 'SafeguardingPolicyName');
		$projectUnits = ArrayHelper::map(projectUnits::find()->all(), 'ProjectUnitID', 'ProjectUnitName');
		$projectRoles = ArrayHelper::map(projectRoles::find()->all(), 'ProjectRoleID', 'ProjectRoleName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->all(), 'SubCountyID', 'SubCountyName', 'CountyID');
		$riskLikelihood = ArrayHelper::map(RiskLikelihood::find()->all(), 'RiskLikelihoodID', 'RiskLikelihoodName');
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');

		for ($x = count($projectFunding); $x <= 4; $x++) {
			$projectFunding[$x] = new ProjectFunding();
		}

		for ($x = count($projectRisk); $x <= 4; $x++) {
			$projectRisk[$x] = new ProjectRisk();
		}

		for ($x = count($projectDisbursement); $x <= 4; $x++) {
			$projectDisbursement[$x] = new ProjectDisbursement();
		}

		for ($x = count($projectSafeguardingPolicies); $x <= 4; $x++) {
			$projectSafeguardingPolicies[$x] = new ProjectSafeguardingPolicies();
		}

		for ($x = count($projectBeneficiaries); $x <= 4; $x++) {
			$projectBeneficiaries[$x] = new ProjectBeneficiaries();
		}

		for ($x = count($projectNotes); $x <= 4; $x++) {
			$projectNotes[$x] = new ProjectNotes();
		}

		for ($x = count($projectTeams); $x <= 4; $x++) {
			$projectTeams[$x] = new ProjectTeams();
		}

		for ($x = count($reportingPeriods); $x <= 4; $x++) {
			$reportingPeriods[$x] = new ReportingPeriods();
		}

		return $this->render('update', [
			'model' => $model,
			'projects' => $projects,
			'projectStatus' => $projectStatus,
			'fundingSources' => $fundingSources,
			'projectFunding' => $projectFunding,
			'projectRisk' => $projectRisk,
			'riskRating' => $riskRating,
			'projectDisbursement' => $projectDisbursement,
			'projectSafeguardingPolicies' => $projectSafeguardingPolicies,
			'safeguardingpolicies' => $safeguardingpolicies,
			'projectBeneficiaries' => $projectBeneficiaries,
			'projectNotes' => $projectNotes,
			'projectUnits' => $projectUnits,
			'projectRoles' => $projectRoles,
			'projectTeams' => $projectTeams,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'riskLikelihood' => $riskLikelihood,
			'components' => $components,
			'reportingPeriods' => $reportingPeriods,
		]);
	}

	/**
	 * Deletes an existing projects model.
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
	 * Finds the projects model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return projects the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Projects::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	private static function saveProjectFunding($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectFundingID'] == '') {
				if (trim($column['FundingSourceID']) != '') {
					$_column = new ProjectFunding();
					$_column->ProjectID = $model->ProjectID;
					$_column->FundingSourceID = $column['FundingSourceID'];
					$_column->Amount = $column['Amount'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectFunding::findOne($column['ProjectFundingID']);
				$_column->FundingSourceID = $column['FundingSourceID'];
				$_column->Amount = $column['Amount'];
				$_column->save();
			}
		}
	}

	private static function saveProjectRisk($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectRiskID'] == '') {
				if (trim($column['ProjectRiskName']) != '') {
					$_column = new ProjectRisk();
					$_column->ProjectID = $model->ProjectID;
					$_column->ProjectRiskName = $column['ProjectRiskName'];
					$_column->RiskRatingID = $column['RiskRatingID'];
					$_column->RiskLikelihoodID = $column['RiskLikelihoodID'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectRisk::findOne($column['ProjectRiskID']);
				$_column->ProjectRiskName = $column['ProjectRiskName'];
				$_column->RiskRatingID = $column['RiskRatingID'];
				$_column->RiskLikelihoodID = $column['RiskLikelihoodID'];
				$_column->save();
			}
		}
	}

	private static function saveprojectSafeguardingPolicies($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectSafeguardingPolicyID'] == '') {
				if (trim($column['SafeguardingPolicyID']) != '') {
					$_column = new ProjectSafeguardingPolicies();
					$_column->ProjectID = $model->ProjectID;
					$_column->SafeguardingPolicyID = $column['SafeguardingPolicyID'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectSafeguardingPolicies::findOne($column['ProjectSafeguardingPolicyID']);
				$_column->SafeguardingPolicyID = $column['SafeguardingPolicyID'];
				$_column->save();
			}
		}
	}

	private static function saveprojectDisbursement($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectDisbursementID'] == '') {
				if (trim($column['Year']) != '') {
					$_column = new ProjectDisbursement();
					$_column->ProjectID = $model->ProjectID;
					$_column->Year = $column['Year'];
					$_column->Amount = $column['Amount'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectDisbursement::findOne($column['ProjectDisbursementID']);
				$_column->Year = $column['Year'];
				$_column->Amount = $column['Amount'];
				$_column->save();
			}
		}
	}

	private static function saveprojectBeneficiaries($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectBeneficiaryID'] == '') {
				if (trim($column['CountyID']) != '') {
					$_column = new ProjectBeneficiaries();
					$_column->ProjectID = $model->ProjectID;
					$_column->CountyID = $column['CountyID'];
					$_column->SubCountyID = $column['SubCountyID'];
					$_column->HostPopulation = $column['HostPopulation'];
					$_column->RefugeePopulation = $column['RefugeePopulation'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectBeneficiaries::findOne($column['ProjectBeneficiaryID']);
				$_column->CountyID = $column['CountyID'];
				$_column->SubCountyID = $column['SubCountyID'];
				$_column->HostPopulation = $column['HostPopulation'];
				$_column->RefugeePopulation = $column['RefugeePopulation'];
				$_column->save();
			}
		}
	}

	private static function saveprojectTeams($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectTeamID'] == '') {
				if (trim($column['ProjectTeamName']) != '') {
					$_column = new ProjectTeams();
					$_column->ProjectID = $model->ProjectID;
					$_column->ProjectTeamName = $column['ProjectTeamName'];
					$_column->Specialization = $column['Specialization'];
					$_column->ProjectUnitID = $column['ProjectUnitID'];
					$_column->ProjectRoleID = $column['ProjectRoleID'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectTeams::findOne($column['ProjectTeamID']);
				$_column->ProjectTeamName = $column['ProjectTeamName'];
				$_column->ProjectRoleID = $column['ProjectRoleID'];
				$_column->Specialization = $column['Specialization'];
				$_column->ProjectUnitID = $column['ProjectUnitID'];
				$_column->save();
			}
		}
	}

	private static function saveReportingPeriods($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ReportingPeriodID'] == '') {
				if (trim($column['ReportingPeriodName']) != '') {
					$_column = new ReportingPeriods();
					$_column->ProjectID = $model->ProjectID;
					$_column->ReportingPeriodName = $column['ReportingPeriodName'];
					$_column->ExpectedDate = $column['ExpectedDate'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ReportingPeriods::findOne($column['ReportingPeriodID']);
				$_column->ReportingPeriodName = $column['ReportingPeriodName'];
				$_column->ExpectedDate = $column['ExpectedDate'];
				$_column->save();
			}
		}
	}

	private static function saveprojectNotes($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectNoteID'] == '') {
				if (trim($column['Notes']) != '') {
					$_column = new ProjectNotes();
					$_column->ProjectID = $model->ProjectID;
					$_column->Notes = $column['Notes'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectNotes::findOne($column['ProjectNoteID']);
				$_column->Notes = $column['Notes'];
				$_column->save();
			}
		}
	}

	public function actionSubCounties($id)
	{
		$model = SubCounties::find()->where(['CountyID' => $id])->all();
			
		if (!empty($model)) {
			foreach ($model as $item) {
				echo "<option value='" . $item->SubCountyID . "'>" . $item->SubCountyName . "</option>";
			}
		} else {
			echo '<option>-</option>';
		}
	}

	public function actionModalContent()
	{
		return '2122323';
	}
}
