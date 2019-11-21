<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\projects */

$this->title = 'Update Projects: ' . $model->ProjectName;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectName, 'url' => ['view', 'id' => $model->ProjectID]];
$this->params['breadcrumbs'][] = 'Update';
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
		'reportingPeriods' => $reportingPeriods
	]) ?>

</section>
