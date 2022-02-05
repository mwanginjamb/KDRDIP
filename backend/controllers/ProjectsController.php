<?php

namespace backend\controllers;

use app\models\Countries;
use app\models\Currencies;
use app\models\FinancialYear;
use app\models\ImportProjects;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
use app\models\ProjectImages;
use app\models\ProjectQuestionnaire;
use app\models\CommunityGroups;
use app\models\YouthPlacement;
use app\models\ProducerOrganizations;
use app\models\Businesses;
use app\models\Communities;
use app\models\ProjectSectors;
use app\models\ProjectSectorInterventions;
use app\models\SubComponentCategories;
use app\models\SubComponents;
use app\models\EnterpriseTypes;
use app\models\ImplementationStatus;
use app\models\Kobo;
use app\models\ProjectQuestionResponses;
use app\models\ProjectChallengesImp;
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
	// public const MAIN_URL = '';
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
			'pagination' => false,
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
		// print('<pre>');
		// print_r(Yii::$app->request->post()); exit;
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

		$projectQuestionResponses = new ActiveDataProvider([
			'query' => ProjectQuestionResponses::find()->where(['ProjectID'=> $id]),
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
			'projectQuestionResponses' => $projectQuestionResponses,
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
		$model->ComponentID = 0;
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

		if ($model->load(Yii::$app->request->post()) ) {
			$this->saveProjectSafeguards(Yii::$app->request->post()['ProjectSafeguards'], $model);
			$this->saveProjectFunding(Yii::$app->request->post()['ProjectFunding'], $model);
			$this->saveProjectRisk(Yii::$app->request->post()['ProjectRisk'], $model);
			$this->saveprojectDisbursement(Yii::$app->request->post()['ProjectDisbursement'], $model);
			$this->saveprojectSafeguardingPolicies(Yii::$app->request->post()['ProjectSafeguardingPolicies'], $model);
			$this->saveprojectBeneficiaries(Yii::$app->request->post()['ProjectBeneficiaries'], $model);
			$this->saveprojectNotes(Yii::$app->request->post()['ProjectNotes'], $model);
			$this->saveprojectTeams(Yii::$app->request->post()['ProjectTeams'], $model);
			$this->saveReportingPeriods(Yii::$app->request->post()['ReportingPeriods'], $model);

			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			if($model->save())
			{
				Yii::$app->session->setFlash('success', 'Record Saved Successfully.', true);
				//return ['success' => 'Record Saved Successfully'];
			}else{
				if(count($model->errors))
				{
					Yii::$app->session->setFlash('error', $model->getErrorSummary(true), true);
					//return ['errors' => $model->getErrorSummary(true)];
					
				}
			}

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
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		// $subCounties = ArrayHelper::map(SubCounties::find()->orderBy('SubCountyName')->all(), 'SubCountyID', 'SubCountyName');
		// $locations = ArrayHelper::map(Locations::find()->orderBy('LocationName')->all(), 'LocationID', 'LocationName');
		$projectSectors = ArrayHelper::map(ProjectSectors::find()->all(), 'ProjectSectorID', 'ProjectSectorName');
		$projectSectorInterventions = ArrayHelper::map(ProjectSectorInterventions::find()->all(), 'SectorInterventionID', 'SectorInterventionName');
		$subComponentCategories = ArrayHelper::map(SubComponentCategories::find()->all(), 'SubComponentCategoryID', 'SubComponentCategoryName');
		$subComponents = ArrayHelper::map(SubComponents::find()->andWhere(['ComponentID' => $model->ComponentID])->all(), 'SubComponentID', 'SubComponentName');
		$enterpriseTypes = ArrayHelper::map(EnterpriseTypes::find()->all(), 'EnterpriseTypeID', 'EnterpriseTypeName');

		$subCounties = ArrayHelper::map(SubCounties::find()->where(['CountyID' => $model->CountyID ])->all(), 'SubCountyID', 'SubCountyName');
		$locations = ArrayHelper::map(Locations::find()->where(['LocationID' => $model->SubCountyID ])->all(), 'LocationID', 'LocationName');
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->LocationID ])->all(), 'SubLocationID', 'SubLocationName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID ])->all(), 'WardID', 'WardName');
		
		// $subLocations = [];
		// $wards = [];
	
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
		$gender = ['M' => 'Male', 'F' => 'Female'];

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
			'projectSectors' => $projectSectors,
			'gender' => $gender,
			'projectSectorInterventions' => $projectSectorInterventions,
			'subComponentCategories' => $subComponentCategories,
			'subComponents' => $subComponents,
			'enterpriseTypes' => $enterpriseTypes,
            'fy' => ArrayHelper::map(FinancialYear::find()->all(), 'id', 'year' ),
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

		if ($model->load(Yii::$app->request->post()) ) {
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
			

			//Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			if($model->save())
			{
				Yii::$app->session->setFlash('success', 'Record Saved Successfully.', true);
				//return ['success' => 'Record Saved Successfully'];
			}else{
				if(count($model->errors))
				{
					Yii::$app->session->setFlash('error', $model->getErrorSummary(true), true);
					//return ['errors' => $model->getErrorSummary(true)];
					
				}
			}
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
		$subLocations = ArrayHelper::map(SubLocations::find()->where(['LocationID' => $model->WardID ])->all(), 'SubLocationID', 'SubLocationName');
		$wards = ArrayHelper::map(Wards::find()->where(['SubCountyID' => $model->SubCountyID ])->all(), 'WardID', 'WardName');

		$projectSectorInterventions = ArrayHelper::map(ProjectSectorInterventions::find()->all(), 'SectorInterventionID', 'SectorInterventionName');
		$subComponentCategories = ArrayHelper::map(SubComponentCategories::find()->all(), 'SubComponentCategoryID', 'SubComponentCategoryName');
		$subComponents = ArrayHelper::map(SubComponents::find()->andWhere(['ComponentID' => $model->ComponentID])->all(), 'SubComponentID', 'SubComponentName');
		$enterpriseTypes = ArrayHelper::map(EnterpriseTypes::find()->all(), 'EnterpriseTypeID', 'EnterpriseTypeName');


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
		$projectSectors = ArrayHelper::map(ProjectSectors::find()->all(), 'ProjectSectorID', 'ProjectSectorName');
		$gender = ['M' => 'Male', 'F' => 'Female'];

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
			'projectSectors' => $projectSectors,
			'gender' => $gender,
			'projectSectorInterventions' => $projectSectorInterventions,
			'subComponentCategories' => $subComponentCategories,
			'subComponents' => $subComponents,
			'enterpriseTypes' => $enterpriseTypes,
            'fy' => ArrayHelper::map(FinancialYear::find()->all(), 'id', 'year' ),
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


    public function actionExcelImport()
    {
        $model = new  ImportProjects();
        return $this->render('excelImport',['model' => $model]);
    }

    public function actionImport()
    {
        $model = new ImportProjects();
        if($model->load(Yii::$app->request->post()))
        {
            $excelUpload = UploadedFile::getInstance($model, 'excel_doc');
            $model->excel_doc = $excelUpload;
            if($uploadedFile = $model->upload())
            {
                // Extract data from  uploaded file
                $sheetData = $this->extractData($uploadedFile);
                // save the data
                $this->saveData($sheetData);
            }else{
                $this->redirect(['excel-import']);
            }

        }else{
            $this->redirect(['excel-import']);
        }
    }

    private function extractData($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }

    private function saveData($sheetData)
    {

         /*print '<pre>';
         print_r($sheetData);
         exit;*/
        $today = date('Y-m-d');
        $component = $sheetData[1]['C'];
        if(!isset($component) || !$component)
        {
                Yii::$app->session->setFlash('error', 'Ensure you excel data import template has a valid component number (Either 1 or 2) Picked :'.$component);
                return $this->redirect(['index']);


        }
        elseif ($component > 2)
        {
            Yii::$app->session->setFlash('error', 'Ensure you excel data import template has a valid component number (Either 1 or 2)');
            return $this->redirect(['index']);
        }
        foreach($sheetData as $key => $data)
        {
            // Read from 3rd row
            if($key >= 3)
            {
                if(trim($data['B']) !== '')
                {
                    $model = new Projects();
                    $model->ProjectName = $data['B'];
                    $model->ComponentID = $component;
                    $model->SubComponentID =  (trim($data['D']) !== '' && $this->getSubComponent($data['D']))? $this->getSubComponent($data['D']): 1 ;
                    $model->SubComponentCategoryID = (trim($data['E'])  !== '' && $this->getSubComponentCategory($data['E']))? $this->getSubComponentCategory($data['E']): 1 ;
                    $model->ProjectSectorID =  (trim($data['F']) !== '' && $this->getProjectSector($data['F']))? $this->getProjectSector($data['F']): 1 ;
                    $model->SectorInterventionID = (trim($data['G']) !== '' && $this->getProjectSectorIntervention($data['G']))? $this->getProjectSectorIntervention($data['G']): 1 ;
                    $model->Objective = (trim($data['H']) !== '')?$data['H']: 'Not Set' ;
                    $model->Justification = (trim($data['I']) !== '')?$data['I']: 'Not Set' ;
                    $model->ProjectCost  = (trim($data['J']) !== '')?$data['J']:0 ;
                    $model->ApprovalDate = (trim($data['K']) !== '')?date('Y-m-d',strtotime($data['K'])):'' ;
                    $model->StartDate = (trim($data['L']) !== '')?date('Y-m-d',strtotime($data['L'])): $today ;
                    $model->EndDate = (trim($data['M']) !== '')?date('Y-m-d',strtotime($data['M'])): $today ;
                    $model->CountyID = (trim($data['N']) !== '')? $this->getCounty($data['N']): 1 ;
                    $model->SubCountyID = (trim($data['O']) !== '')? $this->getSubCounty($data['O']): 1 ;
                    $model->WardID = (trim($data['P']) !== '' && $this->getWard($data['P']))? $this->getWard($data['P']): 1 ;
                    $model->financial_year = (trim($data['Q']) !== '' && $this->getFinancialYear($data['Q']))? $this->getFinancialYear($data['Q']): 1 ; // @todo - write a fxn to get financial yr ID
                    $model->SubLocationID = (trim($data['R']) !== '' && $this->getSublocation($data['R']))? $this->getSublocation($data['R']): 1 ;
                    $model->CommunityID = (trim($data['S']) !== '' && $this->getCPMC($data['S']))? $this->getCPMC($data['S']): 0 ; // "todo - write fxn to get countryid"
                    $model->Latitude = (trim($data['T']) !== '')?$data['T']: 0000 ;
                    $model->Longitude = (trim($data['U']) !== '')?$data['U']:0000 ;
                    $model->CurrencyID = (trim($data['V']) !== '')? $this->getCurrency($data['V']): 1 ;
                    $model->ProjectStatusID = (trim($data['W']) !== '' && $this->getStatus($data['W']))? $this->getStatus($data['W']): 0 ;





                    $model->CreatedBy = Yii::$app->user->identity->UserID;
                    $model->CreatedDate = $today;

                    // Validate Look ups - use index 1

                   /* if($data['A'] == 1)
                    {
                        print($model->ProjectName).'</br>';
                        print($model->ProjectSectorID).'</br>';
                        print($model->SectorInterventionID).'</br>';
                        print($model->ComponentID).'</br>';
                        print($model->SubComponentID).'</br>';
                        print($model->SubComponentCategoryID).'</br>';
                        print($model->CountyID).'</br>';
                        print($model->SubCountyID).'</br>';
                        print($model->CommunityID).'</br>';
                        print($model->ProjectStatusID).'</br>';
                        exit;
                    }*/


                    if(!$model->save())
                    {

                        foreach($model->errors as $k => $v)
                        {
                            Yii::$app->session->setFlash('error',$v[0].' <b>Got value</b>: <i><u>'.$model->$k.'</u></i> On Sub-Project: '.$data['B'].' <b>- On Row:</b>  '.$data['A']);

                        }

                    }else {
                        Yii::$app->session->setFlash('success','Congratulations, all valid records are completely imported into MIS.');
                    }

                }
            }
        }

        if(!empty($component) && $component)
        {
            return $this->redirect(['index','cid' => $component]);
        }
        return $this->redirect(['index']);

    }

    // Data Getter Functions- assist in data import

    private function getSubComponent($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = SubComponents::find()->where(['like',  'SubComponentName',$name])->one();                                                                                                                                                                                                              ;
        if($model)
        {
            return $model->SubComponentID;
        }else{
            return 0; // county not found
        }

    }

    private function getSubComponentCategory($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = SubComponentCategories::find()->where(['like','SubComponentCategoryName',$name])->one();                                                                                                                                                                                                              ;
        if($model)
        {
            return $model->SubComponentCategoryID;
        }else{
            return 0; // county not found
        }

    }

    private function getProjectSector($name)
    {
        if(empty($name)) {
            return 0; // sector not found
        }
        $model = ProjectSectors::find()->where(['like',  'ProjectSectorName',$name])->one();                                                                                                                                                                                                              ;
        if($model)
        {
            return $model->ProjectSectorID;
        }else{
            return 0; // sector not found
        }

    }

    // Get Sector Intervention

    private function getProjectSectorIntervention($name)
    {
        if(empty($name)) {
            return 0; // sector not found
        }
        $model = ProjectSectorInterventions::find()->where(['like',  'SectorInterventionName',$name])->one();                                                                                                                                                                                                              ;
        if($model)
        {
            return $model->SectorInterventionID;
        }else{
            return 0; // sector not found
        }

    }


    private function getCounty($countyName)
    {
        if(empty($countyName)) {
            return 0; // county not found
        }
        $model = Counties::findOne(['CountyName' => $countyName]);
        if($model)
        {
            return $model->CountyID;
        }else{
            return 0; // county not found
        }

    }

    private function getCountry($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = Countries::findOne(['CountryName' => $name]);
        if($model)
        {
            return $model->CountryID;
        }else{
            return 0; // country not found
        }
    }

    private function getSubCounty($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = SubCounties::findOne(['SubCountyName' => $name]);
        if($model)
        {
            return $model->SubCountyID;
        }else{
            return 0; // SubCounty not found
        }
    }

    private function getWard($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = Wards::findOne(['WardName' => $name]);
        if($model)
        {
            return $model->WardID;
        }else{
            return 0; // ward not found
        }
    }

    // same as villages
    private function  getSublocation($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = SubLocations::findOne(['SubLocationName' => $name]);
        if($model)
        {
            return $model->SubLocationID;
        }else{
            return 0; // sublocation not found
        }
    }

    public function getFinancialYear($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = FinancialYear::findOne(['year' => $name]);
        if($model)
        {
            return $model->id;
        }else{
            return 0; // year not found
        }
    }

    public function getCPMC($name)
    {
        if(empty($name)) {
            return 0; // county not found
        }
        $model = Communities::findOne(['CommunityName' => $name]);
        if($model)
        {
            return $model->CommunityID;
        }else{
            return 0; // COMMUNITY/CPMC not found
        }
    }

    public function getCurrency($name)
    {
        if(empty($name)) {
            return 0; //Not found
        }
        $model = Currencies::findOne(['CurrencyName' => $name]);
        if($model)
        {
            return $model->CurrencyID;
        }else{
            return 0; // Currency not found
        }
    }

    public function getStatus($name)
    {
        if(empty($name)) {
            return 0; //Not found
        }
        $model = ProjectStatus::findOne(['ProjectStatusName' => $name]);
        if($model)
        {
            return $model->ProjectStatusID;
        }else{
            return 0; // Proj Status not found
        }
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
					$_column->HostPopulationMale = $column['HostPopulationMale'];
					$_column->RefugeePopulationMale = $column['RefugeePopulationMale'];
					$_column->RefugeePopulationMale = $column['RefugeePopulationMale'];
					$_column->HostPopulationFemale = $column['HostPopulationFemale'];
					$_column->RefugeePopulationFemale = $column['RefugeePopulationFemale'];
					$_column->CreatedBy = Yii::$app->user->identity->UserID;
					$_column->save();
				}
			} else {
				$_column = ProjectBeneficiaries::findOne($column['ProjectBeneficiaryID']);
				$_column->CountyID = $column['CountyID'];
				$_column->SubCountyID = $column['SubCountyID'];
				$_column->HostPopulationMale = $column['HostPopulationMale'];
				$_column->RefugeePopulationMale = $column['RefugeePopulationMale'];
				$_column->HostPopulationFemale = $column['HostPopulationFemale'];
				$_column->RefugeePopulationFemale = $column['RefugeePopulationFemale'];
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
		$model = SubCounties::find()->orderBy('SubCountyName')->where(['CountyID' => $id])->all();
			
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
		$model = Wards::find()->orderBy('WardName')->where(['SubCountyID' => $id])->all();
			
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
		//$model = Locations::find()->orderBy('SubCountyName')->where(['SubCountyID' => $id])->all();
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

	public function actionCommunities($id)
	{
		$model = Communities::find()->where(['CountyID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->CommunityID . "'>" . $item->CommunityName . '</option>';
			}
		} else {
			echo '<option value="0">Select...</option>';
		}
	}

	public function actionDisbursements($id)
	{
		$model = ProjectDisbursement::find()->where(['ProjectID' => $id])->all();
			
		if (!empty($model)) {
			echo '<option value="0">Select...</option>';
			foreach ($model as $item) {
				echo "<option value='" . $item->ProjectDisbursementID . "'>" . $item->Year . '</option>';
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

	public function actionAPIImport()
	{
		// echo strtotime('2020-04-05T14:45:41.953+03:00');
		// exit;
		// $url = 'https://kc.kobotoolbox.org/api/v1/data/425000?format=json';
		$url = 'https://kc.kobotoolbox.org/api/v1/data/506020?format=json';
		// $url = 'https://kc.kobotoolbox.org/api/v1/data/506020?format=json&query={"today": {"$gte": "2020-09-08"}}'; // Test
		$url = 'https://kc.kobotoolbox.org/api/v1/data/425000?format=json&query={"today": {"$gte": "2020-10-01"}}'; // Production
		$token = 'd3387997e65bd2d4e75ee73ccd86e6b5439407ff';

		$result = self::fetchData($url, $token);
		// echo $result; exit;
		// $res = json_decode($result);
		$res = json_decode($result);
		$data = ArrayHelper::toArray($res);
		// print('<pre>');
		// print_r($data); exit;

		// if ($res == null) {
		// 	return  ['error' => 'Failed to Process Request1'];
		// } else {
		// 	return $res;
		// }
		$projectData = [];
		foreach ($data as $res) {
			$_id = self::extractData($res, '_id');

			if (!self::alreadyImported($_id)) {
				// $projectData['IntegrationID'] = self::extractData($res, 'projectsite_info/site_id');
				$projectData['ProjectID'] = self::extractData($res, 'projectsite_info/site_id');
				if (!self::projectExists($projectData['ProjectID'])) {
					$projectData['ProjectName'] = self::extractData($res, 'projectsite_info/site_name');
					$projectData['Objective'] = self::extractData($res, 'projectsite_info/Site_Description');
					$projectData['StartDate'] = date('Y-m-d', strtotime(self::extractData($res, 'start')));
					$projectData['EndDate'] = date('Y-m-d', strtotime(self::extractData($res, 'end')));
					$projectData['ComponentID'] = self::getComponentId(self::extractData($res, 'projectsite_info/component'));
					$projectData['CountyID'] = self::extractData($res, 'Geography/county');
					$projectData['WardID'] = self::extractData($res, 'Geography/ward');
					$projectData['Village'] = self::extractData($res, 'Geography/Village_community');
					$projectData['SubCountyID'] = self::extractData($res, 'Geography/Subcounty');
					$projectData['ContactPerson'] = self::extractData($res, 'Primary_Informant_Name');
					$projectData['Beneficiaries'] = self::extractData($res, 'projectsite_info/beneficiaries');
					$projectData['Enumerator'] = self::extractData($res, 'enumerator_name');
					$projectData['ProjectStatusID'] = self::getProjectStatusId(self::extractData($res, 'projectsite_info/implementation_status'));
					$projectData['Location'] = self::extractData($res, 'Geography/Location');
					$geolocation = self::extractData($res, '_geolocation');
					$projectData['Latitude'] = isset($geolocation[0]) ? $geolocation[0] : '';
					$projectData['Longitude'] = isset($geolocation[1]) ? $geolocation[1] : '';
					$projectData['CurrencyID'] = 1;
					$projectData['CommunityID'] = 0;
					$projectData['LocationID'] = 0;
					$projectData['SubLocationID'] = 0;
					$projectData['Justification'] = $projectData['Objective'];
					$projectData['ApprovalDate'] = date('Y-m-d', strtotime(self::extractData($res, '_submission_time')));

					$projectId = self::saveProject($projectData);
				} else {
					// $project = Projects::findOne(['IntegrationID' => $projectData['IntegrationID']]);
					$project = Projects::findOne($projectData['ProjectID']);
					
					$projectId = empty($project) ? null : $project->ProjectID;
				}
				// echo $projectId; exit;
				if ($projectId) {
					// Save implementation Status
					//Calculate the year quarter.
					$quarter = ceil(date('n') / 3);
					switch ($quarter) {
						case 1:
						  	$realQuarter = 3;
						  	break;
						case 2:
							$realQuarter = 4;
						  	break;
						case 3:
							$realQuarter = 1;
							  break;
						case 4:
							$realQuarter = 2;
							break;
						default:
							$realQuarter = 0;
					}

					// echo $realQuarter; exit;

					$implementationStatus = ImplementationStatus::findOne(['ProjectID' => $projectId, 'PeriodID' => $realQuarter]);
					if (!$implementationStatus) {
						$implementationStatus = new ImplementationStatus();
						$implementationStatus->ProjectID = $projectId;
						$implementationStatus->PeriodID = $realQuarter;
					}					
					$implementationStatus->ProjectStatusID = self::getProjectStatusId(self::extractData($res, 'projectsite_info/implementation_status'));
					$implementationStatus->Date = self::extractData($res, 'today');
					
					if (!$implementationStatus->save()) {
						// print_r($implementationStatus->getErrors()); exit;
					}


					// Save attachments;
					$attachements = self::extractData($res, '_attachments');
					foreach ($attachements as $attachement) {
						$id = self::extractData($attachement, 'id');
						$imageData = [];
						if (!self::imageExists($id)) {
							$smallImage = self::extractData($attachement, 'download_small_url');
							$mediumImage = self::extractData($attachement, 'download_medium_url');
							$largeImage = self::extractData($attachement, 'download_large_url');
							$image = self::extractData($attachement, 'download_url');
							$mimeType = self::extractData($attachement, 'mimetype');
							$filename = self::getFilenme(self::extractData($attachement, 'filename'));
							
							// echo $filename . '</br>';
							// self::downloadFile($smallImage, $token, 'small/' . $filename); // Download Small Image
							// self::downloadFile($mediumImage, $token, 'medium/' . $filename); // Download Medium Image
							// self::downloadFile($largeImage, $token, 'large/' . $filename); // Download Large Image

							// self::downloadFile($image, $token, $filename); // Download Image
							$base64 = self::downloadFileBase64($image, $token, $filename, $mimeType);

							$imageData['ProjectID'] = $projectId;
							$imageData['Caption'] = $filename;
							// $imageData['Image'] = $filename;
							$imageData['Image'] = $base64;
							$imageData['IntegrationID'] = $id;
							if (self::saveImage($imageData)) {
							}
						}
					}

					// Save Site Issues
					$issues = self::extractData($res, 'projectsite_info/site_issues');

					$projectChallenges = new ProjectChallengesImp();
					$projectChallenges->ProjectID = $projectId;
					$projectChallenges->Challenge = $issues;
					$projectChallenges->ProjectChallengeStatusID = 1;
					$projectChallenges->MajorChallenge = 0;
					// $projectChallenges->save();
					if (!$projectChallenges->save()) {
						// print_r($projectChallenges->getErrors()); exit;
					}

					// Capture Additional Questions
					/** 1. projectsite_info/involve_land - 1
					 *  2. projectsite_info/land_size - 2
					 *  3. projectsite_info/irrigation - 3
					 *  4. projectsite_info/new_improved - 5
					 */

					$response1 = self::extractData($res, 'projectsite_info/involve_land');
					self::saveResultQuestions(1, $projectId, $response1);

					$response2 = self::extractData($res, 'projectsite_info/land_size');
					self::saveResultQuestions(2, $projectId, $response2);

					$response3 = self::extractData($res, 'projectsite_info/irrigation');
					self::saveResultQuestions(3, $projectId, $response3);

					$response5 = self::extractData($res, 'projectsite_info/new_improved');
					self::saveResultQuestions(5, $projectId, $response5);

					self::saveContent(['KoboID' => $_id, 'ProjectID' => $projectId, 'Content' => $result]);

					// echo "1235"; exit;
				}
			}
			
		}
		\Yii::$app->session->setFlash('success', 'Import Completed');
		return $this->redirect(['index']);
	}

	public static function alreadyImported($id)
	{
		return Kobo::findOne($id);
	}

	public static function saveContent($params)
	{
		$model = new Kobo();
		if ($model->load(['Kobo' => $params]) && $model->save()) {
			return true;
		}
		return false;
	}

	public static function saveResultQuestions($questionId, $projectId, $response)
	{
		$model = ProjectQuestionResponses::findOne(['ProjectID' => $projectId, 'projectResultQuestionID' => $questionId]);
		if (!$model) {
			$model = new ProjectQuestionResponses();
			$model->projectResultQuestionID = $questionId;
			$model->ProjectID = $projectId;
		}
		$model->Response = $response;
		$model->save();
	}

	public static function saveProject($params)
	{
		$data['Projects'] = $params;
		$model = new Projects();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		if ($model->load($data) && $model->save()) {
			return $model->ProjectID;
		} else {
			print('<pre>');
			print_r($model->getErrors());
		}
		return null;
	}

	public static function saveImage($params)
	{
		$data['ProjectImages'] = $params;
		$model = new ProjectImages();
		$model->CreatedBy = Yii::$app->user->identity->UserID;
		if ($model->load($data) && $model->save()) {
			return true;
		} else {
			print('<pre>');
			print_r($model->getErrors());
		}
		return false;
	}

	public static function projectExists($integrationId)
	{
		// if (empty(Projects::findOne(['IntegrationID' => $integrationId]))) {
		if (empty(Projects::findOne($integrationId))) {
			return false;
		}
		return true;
	}

	public static function imageExists($integrationId)
	{
		if (empty(ProjectGallery::findOne(['IntegrationID' => $integrationId]))) {
			return false;
		}
		return true;
	}

	public static function getComponentId($component)
	{
		return str_replace('component', '', $component);
	}

	public static function getProjectStatusId($status)
	{
		$model = ProjectStatus::findOne(['ProjectStatusName' => $status]);
		if (!empty($model)) {
			return $model->ProjectStatusID;
		}
		return 1;
	}

	public static function extractDataAPI($array, $key)
	{
		return isset($array[$key]) ? $array[$key] : null;
	}

	public static function getFilenme($longFilename) {
		$nameArray = explode('/', $longFilename);
		if (!empty($nameArray)) {
			return end($nameArray);
		}
		return null;
	}

	public static function fetchData($url, $token)
	{
			
		$ch = curl_init($url);
		// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'get');
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
															'Content-Type: application/json',
															'Authorization: Token ' . $token
															]);
		$result = curl_exec($ch);

		if (curl_errno($ch)) {
			return ['error' => 'Failed to submit data'];
		} else {
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
				return $result;
			} elseif (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '401') {
				return ['error' => 'Failed to Process Request2'];
			} else {
				$res = json_decode($result);
				if ($res == null) {
					return ['error' => 'Failed to Process Request1'];
				} else {
					return ['error' => 'Failed to Process Request4'];
				}
			}
		}
	}

	public static function sendData($url, $data, $token = '')
	{
		$data_string = json_encode($data);
		// print_r($data_string); exit;
			
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
															'Content-Type: application/json',
															'Authorization: Bearer ' . $token
															]);
		$result = curl_exec($ch);

		$info =  curl_getinfo($ch);
		$info['data'] = $data;
		$info = json_encode($info);

		// self::log('Request: ', $info);
		// self::log('Response: ', $result);

		if (curl_errno($ch)) {
			return (object) ['error' => 'Failed to submit data'];
		} else {
			// echo curl_getinfo($ch, CURLINFO_HTTP_CODE); exit;
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
				$res = json_decode($result);
				if ($res == null) {
					return (object) ['error' => 'Failed to Process Request1'];
				} else {
					return $res;
				}
			} elseif (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '401') {
				return (object) ['error' => 'Failed to Process Request2'];
			} else {
				$res = json_decode($result);
				if ($res == null) {
					return (object) ['error' => 'Failed to Process Request1'];
				} else {
					return $res;
				}
			}
		}
	}

	public static function downloadFile($url, $token, $output_filename)
	{
		$ch = curl_init($url);
		// curl_setopt($ch, CURLOPT_URL, $host);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		curl_setopt($ch, CURLOPT_REFERER, 'https://kc.kobotoolbox.org');
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Token ' . $token
		]);
		$result = curl_exec($ch);
		curl_close($ch);
  
		// print_r($result); // prints the contents of the collected file before writing..
  
  
		// the following lines write the contents to a file in the same directory (provided permissions etc)
		$fp = fopen('images/' . $output_filename, 'w');
		fwrite($fp, $result);
		fclose($fp);
	}

	public static function downloadFileBase64($url, $token, $output_filename, $mimetype)
	{
		$ch = curl_init($url);
		// curl_setopt($ch, CURLOPT_URL, $host);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20); //timeout in seconds
		curl_setopt($ch, CURLOPT_REFERER, 'https://kc.kobotoolbox.org');
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Token ' . $token
		]);
		$result = curl_exec($ch);
		curl_close($ch);
		return 'data:image/' . $mimetype . ';base64,' . base64_encode($result);
	}

	public static function log($label, $data)
	{
		$ip = Yii::$app->getRequest()->getUserIP();
		$filename = 'log/' . date('YmdH') . '_requests.log';
		$req_dump = print_r($_REQUEST, true);
		$fp = fopen($filename, 'a');
		
		fwrite($fp, $label . ' ');
		fwrite($fp, date('Y-m-d h:i a') . ' ' . $ip . ' ');
		fwrite($fp, $data . "\n");
		fclose($fp);
	}
}
