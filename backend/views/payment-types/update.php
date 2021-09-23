<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentTypes */

$this->title = 'Update Payment Types: ' . $model->PaymentTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PaymentTypeID, 'url' => ['view', 'id' => $model->PaymentTypeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
