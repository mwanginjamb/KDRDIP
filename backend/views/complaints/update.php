<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */

$this->title = 'Update Complaints: ' . $model->ComplaintID;
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ComplaintID, 'url' => ['view', 'id' => $model->ComplaintID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complaints-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
