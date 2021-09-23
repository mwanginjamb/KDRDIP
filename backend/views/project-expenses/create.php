<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectExpenses */

$this->title = 'Create Project Expenses';
$this->params['breadcrumbs'][] = ['label' => 'Project Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'rights' => $rights,
		'expenseTypes' => $expenseTypes,
	]) ?>

</section>
