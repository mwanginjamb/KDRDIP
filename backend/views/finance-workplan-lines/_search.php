<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplanLinesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-workplan-lines-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'workplan_id') ?>

    <?= $form->field($model, 'subproject') ?>

    <?= $form->field($model, 'financial_year') ?>

    <?= $form->field($model, 'period') ?>

    <?php // echo $form->field($model, 'sector') ?>

    <?php // echo $form->field($model, 'component') ?>

    <?php // echo $form->field($model, 'subcomponent') ?>

    <?php // echo $form->field($model, 'county') ?>

    <?php // echo $form->field($model, 'subcounty') ?>

    <?php // echo $form->field($model, 'ward') ?>

    <?php // echo $form->field($model, 'village') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'Ha-No') ?>

    <?php // echo $form->field($model, 'project_cost') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
