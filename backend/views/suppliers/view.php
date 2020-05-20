<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Suppliers */

$this->title = 'View Supplier: '.$model->SupplierName;
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = Yii::$app->request->baseUrl;

$Rights = Yii::$app->params['rights'];
$FormID = 6;
?>
<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
					
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

						<p>
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->SupplierID], ['class' => 'btn btn-primary']) : '';?>
							<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->SupplierID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) : '';?>
						</p>

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
						
								<?= $this->render('viewdetails', [
									'model' => $model
								]) ?>
							</div>

							<div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
								<h4 class="form-section" style="margin-bottom: 0px">Price List</h4>
								<?= GridView::widget([
									'dataProvider' => $priceListProvider,
									'layout' => '{items}',
									'tableOptions' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration',
									],
									'columns' => [
										[
											'label'=>'Code',
											'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
											'contentOptions' => ['style' => 'text-align:center'],
											'format'=>'text',
											'value' => 'SupplierCode',
											'contentOptions' => ['style' => 'text-align:left'],
										],				
										[
											'label'=>'Product Name',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'ProductName',
											'contentOptions' => ['style' => 'text-align:left'],
										],
										[
											'label'=>'Unit of Measure',
											'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'UnitofMeasure',
											'contentOptions' => ['style' => 'text-align:left'],
										],		
										[
											'label'=>'Price',
											'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
											'format'=>'decimal',
											'value' => 'Price',
											'contentOptions' => ['style' => 'text-align:right'],
										],	
									],
								]); ?>

							</div>

							<div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
								<h4 class="form-section" style="margin-bottom: 0px">Orders</h4>
								<?= GridView::widget([
									'dataProvider' => $ordersProvider,
									'layout' => '{items}',
									'tableOptions' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration',
									],
									'columns' => [
										/* [
											'label'=>'ID',
											'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
											'contentOptions' => ['style' => 'text-align:center'],
											'format'=>'text',
											'value' => 'PurchaseID',
											'contentOptions' => ['style' => 'text-align:left'],
										], */
										[
											'class' => 'yii\grid\SerialColumn',
											'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
										],
										[
											'label'=>'Date',
											'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
											'contentOptions' => ['style' => 'text-align:center'],
											'format'=>'date',
											'value' => 'CreatedDate',
											'contentOptions' => ['style' => 'text-align:left'],
										],				
										[
											'label'=>'Supplier Name',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'suppliers.SupplierName',
											'contentOptions' => ['style' => 'text-align:left'],
										],
										[
											'label'=>'Approval Status',
											'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'approvalstatus.ApprovalStatusName',
											'contentOptions' => ['style' => 'text-align:left'],
										],		
										[
											'label'=>'Posting Date',
											'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
											'format'=>'date',
											'value' => 'PostingDate',
											'contentOptions' => ['style' => 'text-align:left'],
										],	
									],
								]); ?>

							</div>

							<div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
								<h4 class="form-section" style="margin-bottom: 0px">Product Categories</h4>
								<?= GridView::widget([
									'dataProvider' => $categoriesProvider,
									'layout' => '{items}',
									'tableOptions' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration',
									],
									'columns' => [
										[
											'label'=>'Code',
											'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
											'contentOptions' => ['style' => 'text-align:center'],
											'format'=>'text',
											'value' => 'ProductCategoryID',
											'contentOptions' => ['style' => 'text-align:left'],
										],				
										[
											'label'=>'Category',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'productcategory.ProductCategoryName',
											'contentOptions' => ['style' => 'text-align:left'],
										],
										[
											'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
											'label' => 'Store',
											'attribute' => 'productcategory.stores.StoreName'
										]
									],
								]); ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
