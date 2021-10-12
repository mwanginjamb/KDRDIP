<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthAssignment */

$this->title = 'Update Auth Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auth Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'authItems' => $authItems
    ]) ?>

</div>
