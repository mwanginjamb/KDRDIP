<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuarterlyTargets */

$this->title = 'Update Quarterly Targets: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Quarterly Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quarterly-targets-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
