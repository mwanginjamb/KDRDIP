<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Activity Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-activity-lines-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Procurement Activity Lines', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ProcuementActivityID',
            'ProcurementPlanID',
            'ProcurementPlanActivityID',
            'PlannedDate',
            'PlannedDays',
            //'ActualStartDate',
            //'ActualClosingDate',
            //'comments:ntext',
            //'CreatedDate',
            //'CreatedBy',
            //'UpdatedDate',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
