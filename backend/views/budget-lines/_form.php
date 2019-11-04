<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BudgetLines */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="budget-lines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'BudgetID')->textInput() ?>

    <?= $form->field($model, 'AccountID')->textInput() ?>

    <?= $form->field($model, 'DepartmentID')->textInput() ?>

    <?= $form->field($model, 'Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
