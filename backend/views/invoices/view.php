<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

$baseModel = $model;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = 'View Invoice:' . $model->InvoiceID;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?php
							if ($model->ApprovalStatusID == 0) { ?>
								<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->InvoiceID], ['class' => 'btn btn-primary']) : ''?>
								<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->InvoiceID], [
										'class' => 'btn btn-danger',
										'data' => [
											'confirm' => 'Are you sure you want to delete this item?',
											'method' => 'post',
										],
								]) : ''?>
							
								<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Send for Approval', ['submit', 'id' => $model->InvoiceID], [
									'class' => 'btn btn-danger place-right', 'style' => 'width: 140px !important;margin-right: 5px;',
									'data' => [
												'confirm' => 'Are you sure you want to submit this item?',
												'method' => 'post',
											]
									]) : '' ?>
								<?php
							} ?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
								'attributes' => [
									'InvoiceID',
									'suppliers.SupplierName',
									[
										'attribute' => 'PurchaseID',
										'label' => 'PO No.',
									],
									[
										'attribute' => 'purchases.CreatedDate',
										'label' => 'PO Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									'InvoiceNumber',
									'suppliers.SupplierName',
									'purchases.projects.counties.CountyName',
									'purchases.projects.subCounties.SubCountyName',
									'purchases.projects.wards.WardName',
									'purchases.projects.ProjectName',
									[
										'attribute' => 'InvoiceDate',
										'label' => ' Invoice Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									[
										'attribute' => 'Amount',
										'format' => ['decimal', 2]
									],
									[
										'attribute' => 'CreatedDate',
										'label' => 'Created By',
										'format' => ['date', 'php:d/m/Y h:i a'],
									],							
									'users.fullName',
								],
						]) ?>

						<h4 class="form-section" style="margin-bottom: 0px">Purchase Order</h4>
						<table class="custom-table table-striped table-bordered zero-configuration dataTable no-footer">
						<tbody>
						<?php
							$DID = 0;
							$total = 0;
							foreach ($purchases as $key => $purchase) {
								if ($DID != $purchase['PurchaseID']) { ?>
									<tr role="row">
										<td colspan="5"><?= 'PO. No. ' . $purchase['PurchaseID'] ;?>  <?= 'PO. Date:' . date('d/m/Y', strtotime($purchase['CreatedDate'])); ?></td>
									</tr>
									<!-- <thead> -->
										<tr role="row">
											<td width="5%">ID</td>
											<td>Product</td>
											<td width="15%" style="text-align: right">Quantity Ordered</td>
											<td width="15%" style="text-align: right">Unit Price</td>
											<td width="15%" style="text-align: right">Amount</td>
										</tr>
									<!-- </thead> -->
									<?php
									$DID = $purchase['PurchaseID'];
								}
								?>
								<tr role="row">
									<td width="5%"><?= $key+1; ?></td>
									<td><?= $purchase['ProductName']; ?></td>
									<td width="15%" style="text-align: right"><?= $purchase['Quantity']; ?></td>
									<td width="15%" style="text-align: right"><?= number_format($purchase['UnitPrice'],2); ?></td>
									<td width="15%" style="text-align: right"><?= number_format($purchase['UnitPrice'] * $purchase['Quantity'], 2); ?></td>
								</tr>
							<?php
							$total = $total + ($purchase['UnitPrice'] * $purchase['Quantity']);
						}?>
						<tr role="row">
							<td colspan="4">Total</td>
							<td width="15%" style="text-align: right"><?= number_format($total, 2); ?></td>
						</tr>
						</tbody>
						</table>

						<h4 class="form-section" style="margin-bottom: 0px">GRNs</h4>
						<table class="custom-table table-striped table-bordered zero-configuration dataTable no-footer">
						<tbody>
						<?php
							$DID = 0;
							foreach ($deliveries as $key => $delivery) {
								if ($DID != $delivery['DeliveryID']) { ?>
									<tr role="row">
										<td colspan="3"><?= 'Delivery Note No. ' . $delivery['DeliveryID'] ;?>  <?= 'Delivery Date:' . date('d/m/Y', strtotime($delivery['CreatedDate'])); ?></td>
									</tr>
									<!-- <thead> -->
										<tr role="row">
											<td width="5%">ID</td>
											<td>Product</td>
											<td width="15%" style="text-align: right">Quantity Delivered</td>
										</tr>
									<!-- </thead> -->
									<?php
									$DID = $delivery['DeliveryID'];
								}
								?>
								<tr role="row">
									<td width="5%"><?= $key+1; ?></td>
									<td><?= $delivery['ProductName']; ?></td>
									<td width="15%" style="text-align: right"><?= $delivery['DeliveredQuantity']; ?></td>
								</tr>
							<?php
						}?>
						</tbody>
						</table>
						<h4 class="form-section" style="margin-bottom: 0px">Supporting Documents</h4>
						<?= GridView::widget([
							'dataProvider' => $documentProvider,
							'summary' => '',
							'layout' => '{summary}{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration1',
							],
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'Description',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'Description',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Created Date',
									'headerOptions' => [ 'width' => '17%', 'style'=>'color:black; text-align:left'],
									'format'=>'datetime',
									'value' => 'CreatedDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Created By',
									'headerOptions' => [ 'width' => '15%', 'style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'users.fullName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
									'template' => '{view}',
									'buttons' => [
				
										'view' => function ($url, $model) use ($rights, $baseModel) {
											return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view-document', 'id' => $model->DocumentID, 'InvoiceID' => $baseModel->InvoiceID], ['class' => 'btn-sm btn-primary', 'target' => '_blank']) : '';
										},										
									],
								],
							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
