<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

// $this->title = 'View Payment: '.$model->PaymentID;
switch ($model->ApprovalStatusID) {
	case 1:
		$this->title = 'Payment Review:';
		break;
	case 2:
		$this->title = 'Payment Approvals:';
		break;
	case 3:
		$this->title = 'Payment Approved:';
		break;
	case 4:
		$this->title = 'Payment Rejected:';
		break;
	default:
		$this->title = 'Payment Review:';
}
$this->title = $this->title . ' ' . $model->PaymentID;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 12;
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
						<div class="row">
							<div class="col-lg-5">
								<p>Enter Approval details below</p>
							<?php $form = ActiveForm::begin(); ?>
							<?= $form->field($notes, 'Note')->textarea(['rows' => 3]) ?>
							<input type="hidden" id="option" name="option" value="<?= $option; ?>">
							<?php // $form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

							<div class="form-group">
								<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
								<?= (isset($rights->Edit)) ? Html::submitButton('<i class="ft-check"></i> Approve', ['class' => 'btn btn-success', 'name'=>'Approve']) : '';?>
								<?= (isset($rights->Edit)) ? Html::submitButton('<i class="ft-x"></i> Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']) : ''; ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $model,
								'attributes' => [
									'PaymentID',
									[
										'attribute' => 'Date',
										'label' => 'PaymentDate',
										'format' => ['date', 'php:d/m/Y'],
									],
									'suppliers.SupplierName',
									[
										'attribute' => 'InvoiceID',
										'label' => 'Invoice No.',
									],
									[
										'attribute' => 'invoices.InvoiceDate',
										'label' => ' Invoice Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									'paymentMethods.PaymentMethodName',
									'bankAccounts.AccountName',
									'RefNumber',
									'Description',
									[
										'attribute' => 'Amount',
										'format' => ['decimal', 2]
									],
									[
										'attribute' => 'CreatedDate',
										'label' => 'Created Date',
										'format' => ['date', 'php:d/m/Y h:i a'],
									],	
									[						
										'attribute' => 'users.fullName',
										'label' => 'Created By'
									]
								],
						]) ?>
						
						<h4 class="form-section" style="margin-bottom: 0px">Invoice</h4>
						<?= DetailView::widget([
							'model' => $invoice,
								'attributes' => [
									'InvoiceID',
									[
										'attribute' => 'InvoiceDate',
										'label' => 'Invoice Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									'InvoiceNumber',
									[
										'attribute' => 'Amount',
										'format' => ['decimal', 2]
									],
								],
						]) ?>

						<h4 class="form-section" style="margin-bottom: 0px">Purchase Order</h4>
						<table class="custom-table table-striped table-bordered zero-configuration dataTable no-footer">
						<tbody>
						<?php
							$DID = 0;
							foreach ($purchases as $key => $purchase) {
								if ($DID != $purchase['PurchaseID']) { ?>
									<tr role="row">
										<td colspan="3"><?= 'PO. No. ' . $purchase['PurchaseID'] ;?>  <?= 'PO. Date:' . date('d/m/Y', strtotime($purchase['CreatedDate'])); ?></td>
									</tr>
									<!-- <thead> -->
										<tr role="row">
											<td width="5%">ID</td>
											<td>Product</td>
											<td width="15%" style="text-align: right">Quantity Ordered</td>
										</tr>
									<!-- </thead> -->
									<?php
								}
								?>
								<tr role="row">
									<td width="5%"><?= $key+1; ?></td>
									<td><?= $purchase['ProductName']; ?></td>
									<td width="15%" style="text-align: right"><?= $purchase['Quantity']; ?></td>
								</tr>
							<?php
						}?>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
