<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Budget */

$this->title = 'Create Budget';
$this->params['breadcrumbs'][] = ['label' => 'Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'budgetLines' => $budgetLines,
	]) ?>

</section>