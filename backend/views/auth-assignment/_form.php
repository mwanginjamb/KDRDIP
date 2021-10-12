<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->dropDownList($authItems, ['prompt' => 'Select ...'])?>

    <?= $form->field($model, 'user_id')->dropDownList($users, ['prompt' => 'Select ...']) ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
