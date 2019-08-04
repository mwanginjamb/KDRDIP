<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Support */

$this->title = 'Update Support: ' . $model->SupportID;
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SupportID, 'url' => ['view', 'id' => $model->SupportID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="support-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
