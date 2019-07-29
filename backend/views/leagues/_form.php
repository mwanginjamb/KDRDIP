<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Leagues */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leagues-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LeagueName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RegionID')->textInput() ?>

    <?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
