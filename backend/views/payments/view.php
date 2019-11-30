<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = 'View Payment: ' . $model->PaymentID;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
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
								<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->PaymentID], ['class' => 'btn btn-primary']) ?>
								<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->PaymentID], [
										'class' => 'btn btn-danger',
										'data' => [
											'confirm' => 'Are you sure you want to delete this item?',
											'method' => 'post',
										],
								]) ?>
								<?php
							} ?>

							<?php if ($model->ApprovalStatusID == 0) { ?>
								<?= Html::a('<i class="ft-edit"></i> Send for Approval', ['submit', 'id' => $model->PaymentID], [
									'class' => 'btn btn-danger place-right', 'style' => 'width: 140px !important;margin-right: 5px;',
									'data' => [
												'confirm' => 'Are you sure you want to submit this item?',
												'method' => 'post',
											]
									]) ?>
								<?php
							}
							?>	
						</p>

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
								/* 	[						
										'attribute' => 'users.fullName',
										'label' => 'Created By'
									], */
									[
										'label'=>'Requested By',
										'attribute' => 'users.fullName',
									] ,
									// 'Notes:ntext',				
									'approvalstatus.ApprovalStatusName',
									'ApprovalDate',
								],
						]) ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
