<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leagues */

$this->title = 'Create Leagues';
$this->params['breadcrumbs'][] = ['label' => 'Leagues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leagues-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
