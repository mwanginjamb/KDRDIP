<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = 'Create Invoices';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'suppliers' => $suppliers,
		'purchases' => $purchases,
		'rights' => $rights,
		'documentProvider' => $documentProvider,
		'projects' => $projects,
		'procurementPlanLines' => $procurementPlanLines,
	]) ?>

</section>