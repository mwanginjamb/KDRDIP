<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QuarterlyTargets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quarterly-targets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'targetID')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'Q1')->textInput() ?>

    <?= $form->field($model, 'Q2')->textInput() ?>

    <?= $form->field($model, 'Q3')->textInput() ?>

    <?= $form->field($model, 'Q4')->textInput() ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <?php $form->field($model, 'created_by')->textInput() ?>

    <?php $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
