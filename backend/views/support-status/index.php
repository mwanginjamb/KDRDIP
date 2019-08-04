<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-status-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Support Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SupportStatusID',
            'SupportStatusName',
            'Notes:ntext',
            'CreatedDate',
            'CreatedBy',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
