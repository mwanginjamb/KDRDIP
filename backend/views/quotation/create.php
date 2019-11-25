<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Quotation */

$this->title = 'Create Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'suppliers' => $suppliers, 'lines' => $lines, 
		'products' => $products, 'quotationsuppliers' => $quotationsuppliers,  
		'quotationTypes' => $quotationTypes,
		'accounts' => $accounts,
		'requisitions' => $requisitions
	]) ?>

</section>
