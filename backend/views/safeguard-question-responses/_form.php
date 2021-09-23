<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SafeguardQuestionResponses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="safeguard-question-responses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProjectID')->textInput() ?>

    <?= $form->field($model, 'SafeguardQuestionID')->textInput() ?>

    <?= $form->field($model, 'Response')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
