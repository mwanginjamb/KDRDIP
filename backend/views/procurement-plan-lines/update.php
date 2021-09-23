<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlanLines */

$this->title = 'Update Procurement Plan Lines: ' . $model->ProcumentPlanLineID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plan Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProcumentPlanLineID, 'url' => ['view', 'id' => $model->ProcumentPlanLineID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procurement-plan-lines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
