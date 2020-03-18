<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\projects */

$this->title = 'Create Sub-Project';
$this->params['breadcrumbs'][] = ['label' => 'Sub-Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
	]) ?>

</section>
