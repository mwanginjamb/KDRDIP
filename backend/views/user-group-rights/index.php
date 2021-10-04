<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserGroupRightsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Group Rights';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>

    $(document).ready(function() {
        $('#DataTables_Table_0_wrapper').DataTable( {
            dexampleom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
</script>
<div class="user-group-rights-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Group Rights', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'tableOptions' => [
            'class' => 'custom-table table-striped table-bordered zero-configuration',
        ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'UserGroupRightID',
            [
                'attribute' => 'Group ID',
                'value' => 'group.UserGroupName',
            ],
            [
                'attribute' => 'Page',
                'value' => 'page.PageName',
            ],
            'View',
            'Edit',
            'Create',
            'Delete',
            //'Post',
            //'CreatedBy',
            //'CreatedDate',
            'Deleted',

            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
                'template' => '{view} {edit} {delete}',
                'buttons' => [

                    'view' => function ($url, $model)  {
                        return (1==1) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->UserGroupRightID], ['class' => 'btn-sm btn-primary']) : '';
                    },
                    'edit' => function ($url, $model)  {
                        return (1==1) ? Html::a('<i class="ft-edit"></i> View', ['update', 'id' => $model->UserGroupRightID], ['class' => 'btn-sm btn-primary']) : '';
                    },
                    'delete' => function ($url, $model)  {
                        return (1 == 1 ) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->UserGroupRightID], [
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
