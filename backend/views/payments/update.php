<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = 'Update Payments: ' . $model->PaymentID;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentID, 'url' => ['view', 'id' => $model->PaymentID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'suppliers' => $suppliers,
		'invoices' => $invoices,
		'paymentMethods' => $paymentMethods,
		'bankAccounts' => $bankAccounts
	]) ?>

</section>
