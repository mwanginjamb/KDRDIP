<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Quotation */

$this->title = 'Update Quotation: ' . $model->Description;
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuotationID, 'url' => ['view', 'id' => $model->QuotationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'suppliers' => $suppliers, 'lines' => $lines, 
		'products' => $products, 'quotationsuppliers' => $quotationsuppliers,  
	]) ?>

</section>
