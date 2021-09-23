<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementActivities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-activities-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProcurementActivityName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'UpdatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
