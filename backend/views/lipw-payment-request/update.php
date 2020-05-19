<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequest */

$this->title = 'Update LIPW Payment Request: ' . $model->PaymentRequestID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentRequestID, 'url' => ['view', 'id' => $model->PaymentRequestID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'masterRoll' => $masterRoll,
	]) ?>

</section>

