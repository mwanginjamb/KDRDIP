<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileStatus */

$this->title = 'Update Profile Status: ' . $model->ProfileStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Profile Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProfileStatusID, 'url' => ['view', 'id' => $model->ProfileStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
