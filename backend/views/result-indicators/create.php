<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResultIndicators */

$this->title = 'Create Result Indicators';
$this->params['breadcrumbs'][] = ['label' => 'Result Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
