<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingTypes */

$this->title = 'Update Training Types: ' . $model->TrainingTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Training Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TrainingTypeName, 'url' => ['view', 'id' => $model->TrainingTypeId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="training-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</div>
