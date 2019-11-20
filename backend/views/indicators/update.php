<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indicators */

$this->title = 'Update Indicators: ' . $model->IndicatorID;
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IndicatorID, 'url' => ['view', 'id' => $model->IndicatorID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'components' => $components,
		'subComponents' => $subComponents,
		'unitsOfMeasure' => $unitsOfMeasure,
		'projectTeams' => $projectTeams,
		'indicatorTargets' => $indicatorTargets,
		'activities' => $activities
	]) ?>

</section>
