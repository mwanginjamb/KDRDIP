<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthItemType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
