<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequest */

$this->title = 'Update Lipw Payment Request: ' . $model->PaymentRequestID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentRequestID, 'url' => ['view', 'id' => $model->PaymentRequestID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-payment-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
