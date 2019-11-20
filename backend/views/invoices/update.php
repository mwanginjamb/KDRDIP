<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = 'Update Invoices: ' . $model->InvoiceID;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->InvoiceID, 'url' => ['view', 'id' => $model->InvoiceID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'suppliers' => $suppliers,
		'purchases' => $purchases
	]) ?>

</section>
