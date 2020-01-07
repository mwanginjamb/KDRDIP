<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-types-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Types', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'UserTypeID',
            'UserTypeName',
            'Notes:ntext',
            'CreatedBy',
            'CreatedDate',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
