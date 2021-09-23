<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResultIndicators */

$this->title = 'Update Result Indicators: ' . $model->ResultIndicatorName;
$this->params['breadcrumbs'][] = ['label' => 'Result Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ResultIndicatorID, 'url' => ['view', 'id' => $model->ResultIndicatorID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'indicatorTypes' => $indicatorTypes,
		'targets' => $targets,
		'unitsOfMeasure' => $unitsOfMeasure,
	]) ?>

</section>