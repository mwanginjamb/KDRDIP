<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles and Permissions (Auth Items)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <div class="card">
        <div class="card-header">
            <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-content collapse show">

            <div class="card-body card-dashboard">
                <p>
                    <?= Html::a('Create Role/Permission', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}',
                    //'filterModel' => [],
                    'tableOptions' => [
                        'class' => 'custom-table table-striped table-bordered zero-configuration',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        'name',
                        'itemType.type',
                        'description:ntext',
                        'rule_name',
                        //'data:ntext',
                        //'created_at',
                        //'updated_at',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '13%', 'style' => 'color:black; text-align:center'],
                            'template' => '{view} {edit} {delete}',
                            'buttons' => [

                                'view' => function ($url, $model) {
                                    return (1 == 1) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) : '';
                                },
                                'edit' => function ($url, $model) {
                                    return (1 == 1) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) : '';
                                },
                                'delete' => function ($url, $model) {
                                    return (1 == 1) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->id], [
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


        </div>
    </div>



</div>