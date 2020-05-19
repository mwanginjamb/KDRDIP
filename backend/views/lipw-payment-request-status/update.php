<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequestStatus */

$this->title = 'Update Lipw Payment Request Status: ' . $model->PaymentRequestStatusName;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Request Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentRequestStatusName, 'url' => ['view', 'id' => $model->PaymentRequestStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
	]) ?>

</section>
