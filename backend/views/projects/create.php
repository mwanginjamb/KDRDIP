<?php

use yii\helpers\Html;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\projects */

$this->title = 'Create Sub-Project';
$this->params['breadcrumbs'][] = ['label' => 'Sub-Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
$(window).on("load", function(){
	var componentId = <?= $model->ComponentID ;?>;
	if (componentId == 1) {
		$("#projectsectorid").show();
		$("#organizations").hide();
	} else if (componentId == 3) {
		$("#projectsectorid").hide();
		$("#organizations").show();
	} else {
		$("#projectsectorid").hide();
		$("#organizations").hide();
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
