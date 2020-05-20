<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequestLines */

$this->title = 'Update Lipw Payment Request Lines: ' . $model->PaymentRequestLineID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Request Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentRequestLineID, 'url' => ['view', 'id' => $model->PaymentRequestLineID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lipw-payment-request-lines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
