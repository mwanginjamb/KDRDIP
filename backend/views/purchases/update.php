<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Purchases */

$this->title = 'Update Purchase: ' . $model->PurchaseID;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

	<?= $this->render('_form', [
		'model' => $model, 'suppliers' => $suppliers, 'lines' => $lines, 
		'products' => $products, 'pricelist' => $pricelist, 'usageunits' => $usageunits,
		'quotations' => $quotations,
		'rights' => $rights,
	]) ?>

</section>
