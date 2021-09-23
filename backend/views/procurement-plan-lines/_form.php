<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlanLines */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-plan-lines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProcumentPlanID')->textInput() ?>

    <?= $form->field($model, 'ServiceDescription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UnitOfMeasureID')->textInput() ?>

    <?= $form->field($model, 'Quantity')->textInput() ?>

    <?= $form->field($model, 'ProcumentMethodId')->textInput() ?>

    <?= $form->field($model, 'SourcesOfFunds')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EstimatedCost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'UpdatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
