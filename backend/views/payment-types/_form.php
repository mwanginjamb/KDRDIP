<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PaymentTypeName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Notes')->textarea(['rows' => 2]) ?>

    <?php $form->field($model, 'CreatedDate')->textInput() ?>

    <?php $form->field($model, 'CreatedBy')->textInput() ?>

    <?php $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
