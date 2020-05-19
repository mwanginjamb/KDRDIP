<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentScheduleStatus */

$this->title = 'Update Lipw Payment Schedule Status: ' . $model->PaymentScheduleStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Schedule Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentScheduleStatusID, 'url' => ['view', 'id' => $model->PaymentScheduleStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-payment-schedule-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
