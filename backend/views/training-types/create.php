<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingTypes */

$this->title = 'Create Training Types';
$this->params['breadcrumbs'][] = ['label' => 'Training Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rights' => $rights,
    ]) ?>

</div>
