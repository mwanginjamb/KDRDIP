<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Plan Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plan-lines-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Procurement Plan Lines', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ProcumentPlanLineID',
            'ProcumentPlanID',
            'ServiceDescription',
            'UnitOfMeasureID',
            'Quantity',
            //'ProcumentMethodId',
            //'SourcesOfFunds',
            //'EstimatedCost',
            //'CreatedDate',
            //'UpdatedDate',
            //'CreatedBy',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
