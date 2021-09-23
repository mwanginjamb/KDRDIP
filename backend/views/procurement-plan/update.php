<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlan */

$this->title = 'Update Procurement Plan: ' . $model->FinancialYear;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FinancialYear, 'url' => ['view', 'id' => $model->ProcurementPlanID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'lines' => $lines,
		'procurementMethods' => $procurementMethods,
		'unitsOfMeasure' => $unitsOfMeasure,
	]) ?>

</section>
