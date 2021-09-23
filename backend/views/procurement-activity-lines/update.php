<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementActivityLines */

$this->title = 'Update Procurement Activity Lines: ' . $model->ProcuementActivityID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activity Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProcuementActivityID, 'url' => ['view', 'id' => $model->ProcuementActivityID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procurement-activity-lines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
