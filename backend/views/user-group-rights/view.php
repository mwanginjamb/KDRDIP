<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroupRights */

$this->title = $model->UserGroupRightID;
$this->params['breadcrumbs'][] = ['label' => 'User Group Rights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-group-rights-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->UserGroupRightID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->UserGroupRightID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'UserGroupRightID',
            'UserGroupID',
            'PageID',
            'View',
            'Edit',
            'Create',
            'Delete',
            'Post',
            'CreatedBy',
            'CreatedDate',
            'Deleted',
        ],
    ]) ?>

</div>
