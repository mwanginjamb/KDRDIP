<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlanOptions */

$this->title = 'Update Plan Options: ' . $model->PlanOptionID;
$this->params['breadcrumbs'][] = ['label' => 'Plan Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PlanOptionID, 'url' => ['view', 'id' => $model->PlanOptionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plan-options-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
