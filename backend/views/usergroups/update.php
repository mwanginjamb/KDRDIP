<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroups */

$this->title = 'Update User Groups: ' . $model->UserGroupID;
$this->params['breadcrumbs'][] = ['label' => 'User Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->UserGroupID, 'url' => ['view', 'id' => $model->UserGroupID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
