<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Suppliers */

$this->title = 'Update Supplier: ' . $model->SupplierName;
$baseUrl = Yii::$app->request->baseUrl;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 6;
?>
<div class="card">
	<div class="card-header">
		<h4 class="form-section"><?= $this->title; ?></h4>
		
		<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
				<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
				<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
			</ul>
		</div>
	</div>
	<div class="card-content collapse show">
		<div class="card-body">

		<ul class="nav nav-tabs nav-top-border no-hover-bg">
			<li class="nav-item">
				<a class="nav-link active custom-tabs" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Details</a>
			</li>
			<li class="nav-item">
				<a class="nav-link custom-tabs" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Price List</a>
			</li>
			<li class="nav-item">
				<a class="nav-link custom-tabs" id="base-tab2" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Orders</a>
			</li>
			<li class="nav-item">
				<a class="nav-link custom-tabs" id="base-tab2" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Product Categories</a>
			</li>							
		</ul> 

		<div class="tab-content px-1 pt-1">
			<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
				<h4 class="form-section" style="margin-bottom: 0px">Details</h4>
				<?= $this->render('_form', [
					'model' => $model,
					'country' => $country,
					'contacts' => $contacts,
					'rights' => $rights,
				]) ?>
			</div>

			<div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
				<h4 class="form-section" style="margin-bottom: 0px">Price List</h4>
				<?= $this->render('pricelist', [
					'products' => $priceList, 'supplier' => $model,
					'rights' => $rights,
				]); ?>
			</div>

			<div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
				<h4 class="form-section" style="margin-bottom: 0px">Orders</h4>
				<?= $this->render('orders', [
					'ordersProvider' => $ordersProvider,
					'rights' => $rights,
				]); ?>
			</div>

			<div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
				<h4 class="form-section" style="margin-bottom: 0px">Product Categories</h4>
				<?= $this->render('categories', [
					'categories' => $categories,
					'rights' => $rights,
				]); ?>
			</div>
		</div>

	</div>
</div>
</div>