<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlanBenefits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-benefits-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PlanID')->textInput() ?>

    <?= $form->field($model, 'BenefitID')->textInput() ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
