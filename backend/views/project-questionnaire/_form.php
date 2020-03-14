<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectQuestionnaire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-questionnaire-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProjectQuestionnaireID')->textInput() ?>

    <?= $form->field($model, 'QuestionnaireID')->textInput() ?>

    <?= $form->field($model, 'ProjectID')->textInput() ?>

    <?= $form->field($model, 'Comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
