<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AuthAassignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auth Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'custom-table table-striped table-bordered zero-configuration',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'item_name',
            'user_id',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
                'template' => '{view} {edit} {delete}',
                'buttons' => [

                    'view' => function ($url, $model)  {
                        return (1==1) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) : '';
                    },
                    'edit' => function ($url, $model)  {
                        return (1==1) ? Html::a('<i class="ft-edit"></i> View', ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) : '';
                    },
                    'delete' => function ($url, $model)  {
                        return (1 == 1 ) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn-sm btn-danger btn-xs',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
                                'method' => 'post',
                            ],
                        ]) : '';
                    },

                ],

            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
