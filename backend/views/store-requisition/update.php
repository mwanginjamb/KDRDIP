<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StoreRequisition */

$this->title = 'Update Store Requisition: ' . $model->StoreRequisitionID;
$this->params['breadcrumbs'][] = ['label' => 'Store Requisitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->StoreRequisitionID, 'url' => ['view', 'id' => $model->StoreRequisitionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="flexbox-container">
	
	<p>Enter details below</p>

	<?= $this->render('_form', [
		'model' => $model, 'lines' => $lines, 'products' => $products, 'stores' => $stores,  'users' => $users,
	]) ?>

</section>
