<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementActivities */

$this->title = 'Update Procurement Activities: ' . $model->ProcurementActivityID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProcurementActivityID, 'url' => ['view', 'id' => $model->ProcurementActivityID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procurement-activities-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
