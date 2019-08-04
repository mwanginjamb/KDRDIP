<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportStatus */

$this->title = 'Update Support Status: ' . $model->SupportStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Support Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SupportStatusID, 'url' => ['view', 'id' => $model->SupportStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="support-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
