<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Enterprise Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enterprise-types-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Enterprise Types', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'EnterpriseTypeID',
            'EnterpriseTypeName',
            'Notes:ntext',
            'CreatedDate',
            'CreatedBy',
            //'Deleed',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
