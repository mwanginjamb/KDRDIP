<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complaints-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ComplainantName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PostalAddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PostalCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CountryID')->textInput() ?>

    <?= $form->field($model, 'CountyID')->textInput() ?>

    <?= $form->field($model, 'SubCountyID')->textInput() ?>

    <?= $form->field($model, 'WardID')->textInput() ?>

    <?= $form->field($model, 'Village')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IncidentDate')->textInput() ?>

    <?= $form->field($model, 'ComplaintSummary')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ReliefSought')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ComplaintTypeID')->textInput() ?>

    <?= $form->field($model, 'OfficerJustification')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ComplaintStatusID')->textInput() ?>

    <?= $form->field($model, 'ComplaintTierID')->textInput() ?>

    <?= $form->field($model, 'AssignedUserID')->textInput() ?>

    <?= $form->field($model, 'ComplaintPriorityID')->textInput() ?>

    <?= $form->field($model, 'Resolution')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
