<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplanLines */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-workplan-lines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'workplan_id')->textInput() ?>

    <?= $form->field($model, 'subproject')->textInput() ?>

    <?= $form->field($model, 'financial_year')->textInput() ?>

    <?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sector')->textInput() ?>

    <?= $form->field($model, 'component')->textInput() ?>

    <?= $form->field($model, 'subcomponent')->textInput() ?>

    <?= $form->field($model, 'county')->textInput() ?>

    <?= $form->field($model, 'subcounty')->textInput() ?>

    <?= $form->field($model, 'ward')->textInput() ?>

    <?= $form->field($model, 'village')->textInput() ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ha-No')->textInput() ?>

    <?= $form->field($model, 'project_cost')->textInput() ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
