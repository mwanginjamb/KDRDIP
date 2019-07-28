<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MpesaTransactions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mpesa-transactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TransactionType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BusinessShortCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BillRefNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'InvoiceNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OrgAccountBalance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ThirdPartyTransID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MSISDN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransactionStatusID')->textInput() ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
