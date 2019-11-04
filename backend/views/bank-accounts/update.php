<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */

$this->title = 'Update Bank Accounts: ' . $model->BankAccountID;
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BankAccountID, 'url' => ['view', 'id' => $model->BankAccountID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bank-accounts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
