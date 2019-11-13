<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quotation Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-types-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Quotation Types', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'QuotationTypeID',
            'QuotationTypeName',
            'Notes:ntext',
            'CreatedDate',
            'CreatedBy',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
