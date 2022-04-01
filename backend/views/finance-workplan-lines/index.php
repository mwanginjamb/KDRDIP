<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceWorkplanLinesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finance Workplan Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-workplan-lines-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Finance Workplan Lines', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'workplan_id',
            'subproject',
            'financial_year',
            'period',
            //'sector',
            //'component',
            //'subcomponent',
            //'county',
            //'subcounty',
            //'ward',
            //'village',
            //'site',
            //'Ha-No',
            //'project_cost',
            //'remark:ntext',
            //'created_at',
            //'updated_at',
            //'updated_by',
            //'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
