<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Plans */

$this->title = 'Update Plans: ' . $model->PlanID;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PlanID, 'url' => ['view', 'id' => $model->PlanID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plans-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
