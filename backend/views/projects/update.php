<?php

use yii\helpers\Html;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\projects */

$this->title = 'Update Sub-Project: ' . $model->ProjectName;
$this->params['breadcrumbs'][] = ['label' => 'Sub-Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectName, 'url' => ['view', 'id' => $model->ProjectID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
$(window).on("load", function(){
	var componentId = <?= $model->ComponentID ;?>;
	if (componentId == 1) {
		$("#projectsectorid").show();
		$("#organizations").hide();
		$("#sectorinterventionid").hide();
	} else if (componentId == 2) {
		$("#projectsectorid").show();
		$("#sectorinterventionid").show();		
		$("#organizations").hide();
	} else if (componentId == 3) {
		$("#projectsectorid").hide();
		$("#organizations").show();
		$("#sectorinterventionid").hide();
	} else {
		$("#projectsectorid").hide();
		$("#organizations").hide();
		$("#sectorinterventionid").hide();
	}
});
</script>
<section class="flexbox-container">

	<?= $this->render('_form', [
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
		'rights' => $rights,
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
        'fy' => $fy
	]) ?>

</section>
