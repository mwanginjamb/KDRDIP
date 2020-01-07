<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CashBook */

$this->title = $model->CashBookID;
$this->params['breadcrumbs'][] = ['label' => 'Cash Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cash-book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CashBookID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CashBookID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CashBookID',
            'Date',
            'TypeID',
            'BankAccountID',
            'AccountID',
            'Description:ntext',
            'Debit',
            'Credit',
            'CreatedDate',
            'CreatedBy',
            'Deleted',
        ],
    ]) ?>

</div>
