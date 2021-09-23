<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroupRights */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-group-rights-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'UserGroupID')->textInput() ?>

    <?= $form->field($model, 'PageID')->textInput() ?>

    <?= $form->field($model, 'View')->textInput() ?>

    <?= $form->field($model, 'Edit')->textInput() ?>

    <?= $form->field($model, 'Create')->textInput() ?>

    <?= $form->field($model, 'Delete')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
