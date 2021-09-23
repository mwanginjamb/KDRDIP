<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskStatus */

$this->title = 'Update Task Status: ' . $model->TaskStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Task Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TaskStatusID, 'url' => ['view', 'id' => $model->TaskStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
