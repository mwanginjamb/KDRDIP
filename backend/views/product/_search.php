<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ProductID') ?>

    <?= $form->field($model, 'ProductName') ?>

    <?= $form->field($model, 'Deleted') ?>

    <?= $form->field($model, 'CreatedDate') ?>

    <?= $form->field($model, 'CreatedBy') ?>

    <?php // echo $form->field($model, 'ProductCategoryID') ?>

    <?php // echo $form->field($model, 'UsageUnitID') ?>

    <?php // echo $form->field($model, 'ReOrderLevel') ?>

    <?php // echo $form->field($model, 'UnitPrice') ?>

    <?php // echo $form->field($model, 'Active') ?>

    <?php // echo $form->field($model, 'VATRate') ?>

    <?php // echo $form->field($model, 'ServiceRate') ?>

    <?php // echo $form->field($model, 'SalesRate') ?>

    <?php // echo $form->field($model, 'Image') ?>

    <?php // echo $form->field($model, 'QtyPerUnit') ?>

    <?php // echo $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'CompanyID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
