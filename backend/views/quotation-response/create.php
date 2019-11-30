<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationResponse */

$this->title = 'Create Quotation Response';
$this->params['breadcrumbs'][] = ['label' => 'Quotation Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'lines' => $lines,
		'quotation' => $quotation,
		'supplier' => $supplier
	]) ?>

</section>
