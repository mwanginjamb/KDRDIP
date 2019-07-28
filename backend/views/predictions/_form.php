<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Predictions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="predictions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'RegionID')->textInput() ?>

    <?= $form->field($model, 'LeagueID')->textInput() ?>

    <?= $form->field($model, 'GameTime')->textInput() ?>

    <?= $form->field($model, 'Teams')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Prediction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FinalOutcome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
