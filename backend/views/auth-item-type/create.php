<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthItemType */

$this->title = 'Create Auth Item Type';
$this->params['breadcrumbs'][] = ['label' => 'Auth Item Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
