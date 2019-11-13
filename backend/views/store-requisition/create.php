<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StoreRequisition */

$this->title = 'Create Store Requisition';
$this->params['breadcrumbs'][] = ['label' => 'Store Requisitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">
	
	<p>Enter details below</p>

	<?= $this->render('_form', [
		'model' => $model, 'lines' => $lines, 'products' => $products, 'stores' => $stores,  'users' => $users,
	]) ?>

</section>
