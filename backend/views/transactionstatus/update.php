<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionStatus */

$this->title = 'Update Transaction Status: ' . $model->TransactionStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Transaction Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TransactionStatusID, 'url' => ['view', 'id' => $model->TransactionStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaction-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
