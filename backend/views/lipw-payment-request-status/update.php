<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequestStatus */

$this->title = 'Update Lipw Payment Request Status: ' . $model->PaymentRequestStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Request Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentRequestStatusID, 'url' => ['view', 'id' => $model->PaymentRequestStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-payment-request-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
