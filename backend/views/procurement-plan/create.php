<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlan */

$this->title = 'Create Procurement Plan';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'lines' => $lines,
		'procurementMethods' => $procurementMethods,
		'unitsOfMeasure' => $unitsOfMeasure,
	]) ?>

</section>
