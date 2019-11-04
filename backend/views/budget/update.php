<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Budget */

$this->title = 'Update Budget: ' . $model->FinancialPeriod;
$this->params['breadcrumbs'][] = ['label' => 'Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FinancialPeriod, 'url' => ['view', 'id' => $model->BudgetID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'budgetLines' => $budgetLines,
	]) ?>

</section>
