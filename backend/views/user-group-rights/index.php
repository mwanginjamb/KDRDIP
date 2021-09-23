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
<div class="user-group-rights-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Group Rights', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'UserGroupRightID',
            'UserGroupID',
            'PageID',
            'View',
            'Edit',
            //'Create',
            //'Delete',
            //'Post',
            //'CreatedBy',
            //'CreatedDate',
            //'Deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
