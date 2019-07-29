<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Benefits */

$this->title = 'Create Benefits';
$this->params['breadcrumbs'][] = ['label' => 'Benefits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="benefits-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
