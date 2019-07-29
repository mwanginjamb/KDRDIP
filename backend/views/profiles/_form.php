<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profiles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PasswordHash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AuthKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ValidationCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ProfileStatusID')->textInput() ?>

    <?= $form->field($model, 'PlanID')->textInput() ?>

    <?= $form->field($model, 'PlanOptionID')->textInput() ?>

    <?= $form->field($model, 'PlanExpiry')->textInput() ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
