<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Predictions */

$this->title = 'Create Predictions';
$this->params['breadcrumbs'][] = ['label' => 'Predictions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predictions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
