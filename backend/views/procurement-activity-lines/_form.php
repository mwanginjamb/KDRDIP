<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementActivityLines */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-activity-lines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProcurementPlanID')->textInput() ?>

    <?= $form->field($model, 'ProcurementPlanActivityID')->textInput() ?>

    <?= $form->field($model, 'PlannedDate')->textInput() ?>

    <?= $form->field($model, 'PlannedDays')->textInput() ?>

    <?= $form->field($model, 'ActualStartDate')->textInput() ?>

    <?= $form->field($model, 'ActualClosingDate')->textInput() ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'UpdatedDate')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
