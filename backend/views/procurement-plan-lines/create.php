<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlanLines */

$this->title = 'Create Procurement Plan Lines';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plan Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-plan-lines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
