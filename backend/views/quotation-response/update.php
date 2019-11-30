<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationResponse */

$this->title = 'Update Quotation Response: ' . $model->QuotationResponseID;
$this->params['breadcrumbs'][] = ['label' => 'Quotation Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QuotationResponseID, 'url' => ['view', 'id' => $model->QuotationResponseID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model,
		'lines' => $lines,
		'quotation' => $quotation,
		'supplier' => $supplier
	]) ?>

</section>
