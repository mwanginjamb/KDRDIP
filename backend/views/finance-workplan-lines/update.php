<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FinanceWorkplanLines */

$this->title = 'Update Finance Workplan Lines: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Workplan Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="finance-workplan-lines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
