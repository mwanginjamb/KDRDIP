<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indicators */

$this->title = 'Create Indicators';
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
