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
use app\models\Wards;
use app\models\Indicators;
use app\models\IndicatorTargets;
use app\models\IndicatorActuals;
use app\models\Components;
use app\models\Activities;
use app\models\Locations;
use app\models\SubLocations;
use app\models\QuestionnaireStatus;
use app\models\Budget;
use app\models\Complaints;
use app\models\Documents;
use app\models\ProjectSafeguards;
use app\models\ProjectGallery;
use app\models\ProjectQuestionnaire;
use app\models\CommunityGroups;
use app\models\YouthPlacement;
use app\models\ProducerOrganizations;
use app\models\Businesses;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\web\UploadedFile;

/**
 * ProjectsController implements the CRUD actions for projects model.
 */
class ProjectsController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(36);

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
		$etid = '';
		if (isset(Yii::$app->request->get()['cid']) && Yii::$app->request->get()['cid'] != '') { 
			$projects = Projects::find()->where(['ComponentID' => Yii::$app->request->get()['cid']]);
			$cid = Yii::$app->request->get()['cid'];
		} else {
			$projects = Projects::find();
			$cid = '';
		}
		if (isset(Yii::$app->request->get()['etid']) && Yii::$app->request->get()['etid'] != '') { 
			$projects->andWhere(['EnterpriseTypeID' => Yii::$app->request->get()['etid']]);
			$etid = Yii::$app->request->get()['etid'];
		} 

		$dataProvider = new ActiveDataProvider([
			'query' => $projects,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'cid' => $cid,
			'etid' => $etid,
			'rights' => $this->rights,
		]);
	}

	public function actionExport() {
		$etid = '';
		$model = Projects::find()->joinWith('parentProject')
											->joinWith('projectStatus')
											->select(
												[	
													'projects.ProjectName', 
													'parentProject.ProjectName as ParentProject',
													'projectStatus.ProjectStatusName',
													'projects.StartDate', 
													'parentProject.ProjectID as ProjectParentID',
													'projects.ProjectStatusID',
												]);
											
		if (isset(Yii::$app->request->get()['cid']) && Yii::$app->request->get()['cid'] != '') { 
			$model->andWhere(['projects.ComponentID' => Yii::$app->request->get()['cid']]);
		} 
		if (isset(Yii::$app->request->get()['etid']) && Yii::$app->request->get()['etid'] != '') { 
			$model->andWhere(['projects.EnterpriseTypeID' => Yii::$app->request->get()['etid']]);
		}
		$model = $model->asArray()->all();
		
		$diplayFields = ['ProjectName', 'ParentProject', 'StartDate', 'ProjectStatusName'];
		return ReportsController::WriteExcel($model, 'Project Report', $diplayFields);
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
			$model = $this->findModel($id);
			$this->saveProjectQuestionnaire(Yii::$app->request->post()['ProjectQuestionnaire'], $model);

			$params = Yii::$app->request->post();
			// print ('<pre>');
			// print_r($params); exit;
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

		$projectGallery = new ActiveDataProvider([
			'query' => ProjectGallery::find()->where(['ProjectID'=> $id]),
		]);

		$projectDocuments = new ActiveDataProvider([
			'query' => Documents::find()->where(['RefNumber'=> $id, 'DocumentTypeID' => 2]),
		]);

		$complaints = new ActiveDataProvider([
			'query' => Complaints::find()->where(['ProjectID'=> $id]),
		]);

		$sql = "SELECT safeguards.SafeguardName, temp.* FROM (
					SELECT safeguardparameters.SafeguardParamaterID as SGPID, SafeguardParamaterName, SafeguardID, `projectsafeguards`.* FROM `projectsafeguards` 
					RIGHT JOIN `safeguardparameters` ON `projectsafeguards`.`SafeguardParamaterID` = `safeguardparameters`.`SafeguardParamaterID` 
					AND `ProjectID`= $id
					) as temp 
					JOIN safeguards ON safeguards.SafeguardID = temp.SafeguardID
					ORDER BY SafeguardName, SafeguardParamaterID";

		$projectSafeguards = ProjectSafeguards::findBySql($sql)->asArray()->all();
		$projectSafeguards = ArrayHelper::index($projectSafeguards, null, 'SafeguardName');

		$activitiesArray = Activities::find()->joinWith('indicators')->where(['indicators.ProjectID' => $id])->all();	
		$activities = ArrayHelper::index($activitiesArray, null, 'IndicatorID');		
		$activityTotals = Activities::totals($id);

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

		$sql = "Select *, QuestionnaireCategoryName, QuestionnaireSubCategoryName, temp.QuestionnaireCategoryID, temp.QuestionnaireSubCategoryID from (
					Select questionnaires.QuestionnaireID as QID, Question, QuestionnaireCategoryID, QuestionnaireSubCategoryID, projectquestionnaire.*					
					from projectquestionnaire
					RIGHT JOIN questionnaires ON questionnaires.QuestionnaireID = projectquestionnaire.QuestionnaireID
					AND ProjectID = $id
					) temp
					LEFT JOIN questionnairecategories ON questionnairecategories.QuestionnaireCategoryID = temp.QuestionnaireCategoryID
					LEFT JOIN questionnairesubcategories ON questionnairesubcategories.QuestionnaireSubCategoryID = temp.QuestionnaireSubCategoryID
					ORDER BY temp.QuestionnaireCategoryID, temp.QuestionnaireSubCategoryID";
		$questionnaire = ProjectQuestionnaire::findBySql($sql)->asArray()->all();

		$projectQuestionnaire = [];
		foreach ($questionnaire as $key => $questions) {
			$projectQuestionnaire[$key] = new ProjectQuestionnaire();
			$projectQuestionnaire[$key]->ProjectQuestionnaireID = $questions['ProjectQuestionnaireID'];
			$projectQuestionnaire[$key]->QuestionnaireID = $questions['QuestionnaireID'];
			$projectQuestionnaire[$key]->Question = $questions['Question'];
			$projectQuestionnaire[$key]->QuestionnaireStatusID = $questions['QuestionnaireStatusID'];
			$projectQuestionnaire[$key]->ProjectID = $questions['ProjectID'];
			$projectQuestionnaire[$key]->QuestionnaireCategoryName = $questions['QuestionnaireCategoryName'];
			$projectQuestionnaire[$key]->QuestionnaireSubCategoryName = $questions['QuestionnaireSubCategoryName'];
			$projectQuestionnaire[$key]->QID = $questions['QID'];
			$projectQuestionnaire[$key]->QuestionnaireCategoryID = $questions['QuestionnaireCategoryID'];
			$projectQuestionnaire[$key]->QuestionnaireSubCategoryID = $questions['QuestionnaireSubCategoryID'];
		}
		$questionnaireStatus = ArrayHelper::map(QuestionnaireStatus::find()->orderBy('QuestionnaireStatusName')->all(), 'QuestionnaireStatusID', 'QuestionnaireStatusName');		

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
			'projectSafeguards' => $projectSafeguards,
			'activities' => $activities,
			'activityTotals' => $activityTotals,
			'targets' => $targets,
			'actuals' => $actuals,
			'rights' => $this->rights,
			'projectGallery' => $projectGallery,
			'projectDocuments' => $projectDocuments,
			'complaints' => $complaints,
			'projectQuestionnaire' => $projectQuestionnaire,
			'questionnaireStatus' => $questionnaireStatus,
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
		
		$organizations = [];

		if (isset(Yii::$app->request->get()['etid']) && Yii::$app->request->get()['etid'] != '') {
			$model->EnterpriseTypeID = Yii::$app->request->get()['etid'];
			$etid = Yii::$app->request->get()['etid'];
			if ($etid == 1) {
				$organizations = ArrayHelper::map(CommunityGroups::find()->all(), 'CommunityGroupID', 'CommunityGroupName');
			} elseif ($etid == 2) {
				$organizations = ArrayHelper::map(Businesses::find()->all(), 'BusinessID', 'BusinessName');
			} elseif ($etid == 3) {
				$organizations = ArrayHelper::map(ProducerOrganizations::find()->all(), 'ProducerOrganizationID', 'ProducerOrganizationName');
			} elseif ($etid == 4) {
				$organizations = ArrayHelper::map(YouthPlacement::find()->all(), 'YouthPlacementID', 'YouthPlacementName');
			}
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->saveProjectSafeguards(Yii::$app->request->post()['ProjectSafeguards'], $model);
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
		$currencies = ArrayHelper::map(\app\models\Currencies::find()->all(), 'CurrencyID', 'CurrencyName');
		$communities = ArrayHelper::map(\app\models\Communities::find()->all(), 'CommunityID', 'CommunityName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$subLocations = [];
		$wards = [];
	
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

		$sql = "SELECT safeguards.SafeguardName, temp.* FROM (
			SELECT safeguardparameters.SafeguardParamaterID as SGPID, SafeguardParamaterName, SafeguardID, `projectsafeguards`.* FROM `projectsafeguards` 
			RIGHT JOIN `safeguardparameters` ON `projectsafeguards`.`SafeguardParamaterID` = `safeguardparameters`.`SafeguardParamaterID` 
			AND `ProjectID`= 0
			) as temp 
			JOIN safeguards ON safeguards.SafeguardID = temp.SafeguardID
			ORDER BY SafeguardName, SafeguardParamaterID";

		$safeguardParameters = ProjectSafeguards::findBySql($sql)->asArray()->all();
		$projectSafeguards = [];
		foreach ($safeguardParameters as $parameters) {
			$SGID = $parameters['SGPID'];
			$projectSafeguards[$SGID] = new ProjectSafeguards();
			$projectSafeguards[$SGID]->ProjectSafeguardID = $parameters['ProjectSafeguardID'];
			$projectSafeguards[$SGID]->ProjectID = $parameters['ProjectID'];
			$projectSafeguards[$SGID]->Yes = $parameters['Yes'];
			$projectSafeguards[$SGID]->No = $parameters['No'];
			if ($parameters['Yes'] == 1) {
				$projectSafeguards[$SGID]->SelectedOption = 1;
			} elseif ($parameters['No'] == 1) {
				$projectSafeguards[$SGID]->SelectedOption = 2;
			} else {
				$projectSafeguards[$SGID]->SelectedOption = null;
			}
			$projectSafeguards[$SGID]->SGPID	= 	$SGID;
		}

		$safeguardParameters = ArrayHelper::index($safeguardParameters, null, 'SafeguardName');

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
			'reportingPeriods' => $reportingPeriods,
			'currencies' => $currencies,
			'communities' => $communities,
			'counties' => $counties,
			'projectSafeguards' => $projectSafeguards,
			'safeguardParameters' => $safeguardParameters,
			'rights' => $this->rights,
			'subLocations' => $subLocations,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'wards' => $wards,
			'organizations' => $organizations,
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
			// print('<pre>');
			// print_r(Yii::$app->request->post()); exit;
			$this->saveProjectSafeguards(Yii::$app->request->post()['ProjectSafeguards'], $model);
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
		// $subCounties = ArrayHelper::map(SubCounties::find()->all(), 'SubCountyID', 'SubCountyName', 'CountyID');


		$riskLikelihood = ArrayHelper::map(RiskLikelihood::find()->all(), 'RiskLikelihoodID', 'RiskLikelihoodName');
		$components = ArrayHelper::map(Components::find()->all(), 'ComponentID', 'ComponentName');
		$currencies = ArrayHelper::map(\app\models\Currencies::find()->all(), 'CurrencyID', 'CurrencyName');
		$communities = ArrayHelper::map(\app\models\Communities::find()->all(), 'CommunityID', 'CommunityName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$counties = ArrayHelper::map(Counties::find()->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->where(['LocationID' => $model->SubCountyID ])->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->LocationID ])->all(), 'SubLocationID', 'SubLocationName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID ])->all(), 'WardID', 'WardName');


		$etid = $model->EnterpriseTypeID;
		if ($etid == 1) {
			$organizations = ArrayHelper::map(CommunityGroups::find()->all(), 'CommunityGroupID', 'CommunityGroupName');
		} elseif ($etid == 2) {
			$organizations = ArrayHelper::map(Businesses::find()->all(), 'BusinessID', 'BusinessName');
		} elseif ($etid == 3) {
			$organizations = ArrayHelper::map(ProducerOrganizations::find()->all(), 'ProducerOrganizationID', 'ProducerOrganizationName');
		} elseif ($etid == 4) {
			$organizations = ArrayHelper::map(YouthPlacement::find()->all(), 'YouthPlacementID', 'YouthPlacementName');
		} else {
			$organizations = [];
		}

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

		$sql = "SELECT safeguards.SafeguardName, temp.* FROM (
			SELECT safeguardparameters.SafeguardParamaterID as SGPID, SafeguardParamaterName, SafeguardID, `projectsafeguards`.* FROM `projectsafeguards` 
			RIGHT JOIN `safeguardparameters` ON `projectsafeguards`.`SafeguardParamaterID` = `safeguardparameters`.`SafeguardParamaterID` 
			AND `ProjectID`= $id
			) as temp 
			JOIN safeguards ON safeguards.SafeguardID = temp.SafeguardID
			ORDER BY SafeguardName, SafeguardParamaterID";

		$safeguardParameters = ProjectSafeguards::findBySql($sql)->asArray()->all();
		$projectSafeguards = [];
		foreach ($safeguardParameters as $parameters) {
			$SGID = $parameters['SGPID'];
			$projectSafeguards[$SGID] = new ProjectSafeguards();
			$projectSafeguards[$SGID]->ProjectSafeguardID = $parameters['ProjectSafeguardID'];
			$projectSafeguards[$SGID]->ProjectID = $parameters['ProjectID'];
			$projectSafeguards[$SGID]->Yes = $parameters['Yes'];
			$projectSafeguards[$SGID]->No = $parameters['No'];
			if ($parameters['Yes'] == 1) {
				$projectSafeguards[$SGID]->SelectedOption = 1;
			} elseif ($parameters['No'] == 1) {
				$projectSafeguards[$SGID]->SelectedOption = 2;
			} else {
				$projectSafeguards[$SGID]->SelectedOption = null;
			}
			$projectSafeguards[$SGID]->SGPID	= 	$SGID;
		}
		$safeguardParameters = ArrayHelper::index($safeguardParameters, null, 'SafeguardName');

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
			'currencies' => $currencies,
			'communities' => $communities,
			'counties' => $counties,
			'projectSafeguards' => $projectSafeguards,
			'safeguardParameters' => $safeguardParameters,
			'rights' => $this->rights,
			'subLocations' => $subLocations,
			'subCounties' => $subCounties,
			'locations' => $locations,
			'wards' => $wards,
			'organizations' => $organizations,
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
	
	public function actionSafeguards($id, $op)
	{
		$model = $this->findModel($id);

		$where = '';
		if ($op==1) {
			$where = ' AND Yes = 1';
		} elseif ($op == 2) {
			$where = ' AND No = 1';
		}
		$sql = "SELECT safeguards.SafeguardName, temp.* FROM (
					SELECT safeguardparameters.SafeguardParamaterID as SGPID, SafeguardParamaterName, SafeguardID, `projectsafeguards`.* FROM `projectsafeguards` 
					JOIN `safeguardparameters` ON `projectsafeguards`.`SafeguardParamaterID` = `safeguardparameters`.`SafeguardParamaterID` 
					AND `ProjectID`= $id $where
					) as temp 
					JOIN safeguards ON safeguards.SafeguardID = temp.SafeguardID
					ORDER BY SafeguardName, SafeguardParamaterID";

		$projectSafeguards = ProjectSafeguards::findBySql($sql)->asArray()->all();
		$projectSafeguards = ArrayHelper::index($projectSafeguards, null, 'SafeguardName');
		return $this->renderPartial('safeguards', [
			'model' => $model,
			'projectSafeguards' => $projectSafeguards,
		]);
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
					$_column->BaseCurrencyID = $model->CurrencyID;
					$_column->CurrencyID = $column['CurrencyID'];
					$_column->Rate = $column['Rate'];
					$_column->BaseAmount = $column['BaseAmount'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectFunding::findOne($column['ProjectFundingID']);
				$_column->FundingSourceID = $column['FundingSourceID'];
				$_column->Amount = $column['Amount'];
				$_column->BaseCurrencyID = $model->CurrencyID;
				$_column->CurrencyID = $column['CurrencyID'];
				$_column->Rate = $column['Rate'];
				$_column->BaseAmount = $column['BaseAmount'];
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
					$_column->Date = $column['Date'];
					$_column->Amount = $column['Amount'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectDisbursement::findOne($column['ProjectDisbursementID']);
				$_column->Year = $column['Year'];
				$_column->Date = $column['Date'];
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
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->SubCountyID . "'>" . $item->SubCountyName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionWards($id)
	{
		$model = Wards::find()->where(['SubCountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->WardID . "'>" . $item->WardName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionLocations($id)
	{
		$model = Locations::find()->where(['SubCountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->LocationID . "'>" . $item->LocationName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionSubLocations($id)
	{
		$model = SubLocations::find()->where(['LocationID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->SubLocationID . "'>" . $item->SubLocationName . "</option>";
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function saveProjectSafeguards($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectSafeguardID'] == '') {
				$_column = new ProjectSafeguards();
				$_column->ProjectID = $model->ProjectID;
				$_column->SafeguardParamaterID = $column['SGPID'];
				$_column->Yes = isset($column['SelectedOption']) && $column['SelectedOption'] == 1 ? 1 : 0;
				$_column->No = isset($column['SelectedOption']) && $column['SelectedOption'] == 2 ? 1 : 0;
				$_column->CreatedBy = Yii::$app->user->identity->UserID;
				$_column->save();
			} else {
				$_column = ProjectSafeguards::findOne($column['ProjectSafeguardID']);
				$_column->Yes = isset($column['SelectedOption']) && $column['SelectedOption'] == 1 ? 1 : 0;
				$_column->No = isset($column['SelectedOption']) && $column['SelectedOption'] == 2 ? 1 : 0;
				$_column->save();
			}
		}
	}

	
	public function saveProjectQuestionnaire($columns, $model)
	{
		foreach ($columns as $key => $column) {
			if ($column['ProjectQuestionnaireID'] == '') {
				$_column = new ProjectQuestionnaire();
				$_column->ProjectID = $model->ProjectID;
				$_column->QuestionnaireID = $column['QID'];
				$_column->QuestionnaireStatusID = $column['QuestionnaireStatusID'];
				$_column->CreatedBy = Yii::$app->user->identity->UserID;
				$_column->save();
			} else {
				$_column = ProjectQuestionnaire::findOne($column['ProjectQuestionnaireID']);
				$_column->QuestionnaireStatusID = $column['QuestionnaireStatusID'];
				$_column->save();
			}
		}
	}

	public function actionModalContent()
	{
		return '2122323';
	}

	public function actionDocuments($pid)
	{
		$model = new Documents();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		$model->DocumentTypeID = 2;
		$model->RefNumber = $pid;

		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$filename = (string) time() . '_' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
			$model->imageFile->saveAs('uploads/' . $filename);
			$model->FileName = $filename;
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['projects/view', 'id' => $pid]);
		}

		return $this->render('documents', [
			'model' => $model,
			'ProjectID' => $pid,
		]);
	}

	public function actionViewDocument($id)
	{
		ini_set('max_execution_time', 5*60); // 5 minutes
		$model = Documents::findOne($id);
		ob_clean();

		$file = 'uploads/' . $model->FileName;

		if (file_exists($file)) {
			Yii::$app->response->sendFile($file)->send();
			return;
		}
		return $this->redirect(['projects/view', 'id' => $model->RefNumber]);		
	}
}
