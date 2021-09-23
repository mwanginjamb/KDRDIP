<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementActivities */

$this->title = 'Create Procurement Activities';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-activities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
