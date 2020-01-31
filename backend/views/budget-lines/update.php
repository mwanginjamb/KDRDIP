<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BudgetLines */

$this->title = 'Update Budget Lines: ' . $model->BudgetLineID;
$this->params['breadcrumbs'][] = ['label' => 'Budget Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BudgetLineID, 'url' => ['view', 'id' => $model->BudgetLineID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="budget-lines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		  'model' => $model,
		  'rights' => $rights,
    ]) ?>

</div>
