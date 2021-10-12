<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthItemType */

$this->title = 'Update Auth Item Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auth Item Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-item-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
