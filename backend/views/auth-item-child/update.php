<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthItemChild */

$this->title = 'Update Auth Item Child: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auth Item Children', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-item-child-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authItems' => $authItems,
        'parents' => $parents
    ]) ?>

</div>
