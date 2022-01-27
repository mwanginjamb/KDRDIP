<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentTypes */

$this->title = $model->PaymentTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payment-types-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Home', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->PaymentTypeID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PaymentTypeID], [
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
            'PaymentTypeID',
            'PaymentTypeName',
            'Notes:ntext',
            'CreatedDate',
            'CreatedBy',
            'Deleted',
        ],
    ]) ?>

</div>
