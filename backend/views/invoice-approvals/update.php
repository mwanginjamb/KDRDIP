<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

$this->title = 'Update Requisition: ' . $model->RequisitionID;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
	
		<p>Enter details below</p>

		<?= $this->render('_form', [
			'model' => $model, 'lines' => $lines, 'products' => $products,
			'rights' => $rights,
		]) ?>

	</div>
</section>
