<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActivityBudget */

$this->title = 'Update Activity Budget: ' . $model->ActivityBudgetID;
$this->params['breadcrumbs'][] = ['label' => 'Activity Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ActivityBudgetID, 'url' => ['view', 'id' => $model->ActivityBudgetID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-budget-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
    ]) ?>

</div>
