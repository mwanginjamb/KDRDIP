<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroupRightsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-group-rights-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'UserGroupRightID') ?>

    <?= $form->field($model, 'UserGroupID') ?>

    <?= $form->field($model, 'PageID') ?>

    <?= $form->field($model, 'View') ?>

    <?= $form->field($model, 'Edit') ?>

    <?php // echo $form->field($model, 'Create') ?>

    <?php // echo $form->field($model, 'Delete') ?>

    <?php // echo $form->field($model, 'Post') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <?php // echo $form->field($model, 'CreatedDate') ?>

    <?php // echo $form->field($model, 'Deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
