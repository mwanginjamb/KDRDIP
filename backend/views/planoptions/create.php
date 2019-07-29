<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlanOptions */

$this->title = 'Create Plan Options';
$this->params['breadcrumbs'][] = ['label' => 'Plan Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-options-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
