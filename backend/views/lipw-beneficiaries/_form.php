<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lipw-beneficiaries-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IDNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DateOfBirth')->textInput() ?>

    <?= $form->field($model, 'AlternativeID')->textInput() ?>

    <?= $form->field($model, 'HouseHoldID')->textInput() ?>

    <?= $form->field($model, 'BankAccountNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BankAccountName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BankID')->textInput() ?>

    <?= $form->field($model, 'BranchID')->textInput() ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
