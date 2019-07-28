<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Regions */

$this->title = 'Update Regions: ' . $model->RegionID;
$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->RegionID, 'url' => ['view', 'id' => $model->RegionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="regions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
