<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectExpenses */

$this->title = 'Update Expense ID: ' . $model->ProjectExpenseID;
$this->params['breadcrumbs'][] = ['label' => 'Project Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProjectExpenseID, 'url' => ['view', 'id' => $model->ProjectExpenseID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'expenseTypes' => $expenseTypes,
	]) ?>

</section>
