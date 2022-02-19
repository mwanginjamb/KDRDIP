<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuarterlyTargets */

$this->title = 'Create Quarterly Targets';
$this->params['breadcrumbs'][] = ['label' => 'Quarterly Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="quarterly-targets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
