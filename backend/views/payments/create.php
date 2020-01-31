<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = 'Create Payments';
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
		
	<?= $this->render('_form', [
		'model' => $model,
		'suppliers' => $suppliers,
		'invoices' => $invoices,
		'paymentMethods' => $paymentMethods,
		'bankAccounts' => $bankAccounts,
		'rights' => $rights,
	]) ?>

</section>
