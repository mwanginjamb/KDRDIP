<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProductCategoryID')->textInput() ?>

    <?= $form->field($model, 'SupplierID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
