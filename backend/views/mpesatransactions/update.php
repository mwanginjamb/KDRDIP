<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MpesaTransactions */

$this->title = 'Update Mpesa Transactions: ' . $model->TransactionID;
$this->params['breadcrumbs'][] = ['label' => 'Mpesa Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TransactionID, 'url' => ['view', 'id' => $model->TransactionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mpesa-transactions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
