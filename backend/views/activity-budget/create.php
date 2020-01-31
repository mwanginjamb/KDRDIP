<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActivityBudget */

$this->title = 'Create Activity Budget';
$this->params['breadcrumbs'][] = ['label' => 'Activity Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-budget-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
    ]) ?>

</div>
