<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaires */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questionnaires-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'QuestionnaireTypeID')->textInput() ?>

    <?= $form->field($model, 'QuestionnaireCategoryID')->textInput() ?>

    <?= $form->field($model, 'QuestionnaireSubCategoryID')->textInput() ?>

    <?= $form->field($model, 'Question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
