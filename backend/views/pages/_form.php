<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PageName')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'PageCategoryID')->dropDownList($categories,['prompt' => 'select ...']) ?>

    <?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>

    <?php $form->field($model, 'CreatedDate')->textInput() ?>

    <?php $form->field($model, 'CreatedBy')->textInput() ?>

    <?php $form->field($model, 'Deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
