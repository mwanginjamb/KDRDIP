<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserStatus */

$this->title = 'Update User Status: ' . $model->UserStatusID;
$this->params['breadcrumbs'][] = ['label' => 'User Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UserStatusID, 'url' => ['view', 'id' => $model->UserStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
