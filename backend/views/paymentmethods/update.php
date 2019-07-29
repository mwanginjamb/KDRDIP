<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentMethods */

$this->title = 'Update Payment Methods: ' . $model->PaymentMethodID;
$this->params['breadcrumbs'][] = ['label' => 'Payment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentMethodID, 'url' => ['view', 'id' => $model->PaymentMethodID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-methods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
