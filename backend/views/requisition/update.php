<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

$this->title = 'Update Requisition: ' . $model->RequisitionID;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
	
	<p>Enter details below</p>

	<?= $this->render('_form', [
		'model' => $model,
		'lines' => $lines,
		'products' => $products,
		'stores' => $stores,
		'users' => $users,
		'quotationTypes' => $quotationTypes,
		'projects' => $projects
	]) ?>
	
</section>
