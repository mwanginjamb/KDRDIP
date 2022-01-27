<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-types-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create a Payment Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'PaymentTypeID',
            'PaymentTypeName',
            'Notes:ntext',
            'CreatedDate',
            [
                    'attribute' => 'CreatedBy',
                    'value' => 'user.FirstName'
            ],
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
