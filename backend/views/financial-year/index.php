<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FinancialYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-year-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Financial Year', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'year',
            'created_at:datetime',
            'updated_at:datetime',
            [
                    'attribute' => 'user.FirstName',
                    'label' => 'Created By'
            ],
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
