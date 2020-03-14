<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */

$this->title = 'Create Complaints';
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaints-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
