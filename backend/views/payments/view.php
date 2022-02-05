<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = 'View Payment: ' . $model->PaymentID;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

Modal::begin([
	'header' => '<h4 class="modal-title">Document</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'pdf-viewer',
	'size' => 'modal-lg',
	]);

Modal::end();
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
							<?php	
							if ($model->ApprovalStatusID == 0) { ?>
								<?=  Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->PaymentID], ['class' => 'btn btn-primary']) ?>
								<?=  Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->PaymentID], [
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
							<?php 
							// echo $model->ApprovalStatusID; exit;
							if ($model->ApprovalStatusID == 3) { 
								//echo Html::a('<i class="ft-printer"></i> Payment Voucher', ['payment-voucher', 'id' => $model->PaymentID], ['class' => 'btn btn-primary mr-1']);
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
									'Supplier',
									[
										'attribute' => 'InvoiceNumber',
										'label' => 'Invoice No.',
									],
									[
										'attribute' => 'InvoiceDate',
										'label' => ' Invoice Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									'paymentMethods.PaymentMethodName',
									'bankAccounts.AccountName',
									'RefNumber',
									'Description',
									'invoices.projects.ProjectName',
									'invoices.procurementPlanLines.ServiceDescription',
									'invoices.projects.counties.CountyName',
									'invoices.projects.subCounties.SubCountyName',
									'invoices.projects.wards.WardName',
									'invoices.projects.ProjectName',
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
										'label'=>'Requested By',
										'attribute' => 'users.fullName',
									] ,
									// 'Notes:ntext',				
									'approvalstatus.ApprovalStatusName',
									'ApprovalDate',
								],
						]) ?>






						<h4 class="form-section" style="margin-bottom: 0px">Notes</h4>
						<?= GridView::widget([
							'dataProvider' => $approvalNotesProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'showFooter' =>false,
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'Notes',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'Note',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Date',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format' => ['date', 'php:d/m/Y h:i a'],
									'value' => 'CreatedDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Created By',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'users.fullName',
									'contentOptions' => ['style' => 'text-align:left'],
								],	
							],
						]); ?>

						<!--<h4 class="form-section" style="margin-bottom: 0px">Documents</h4>	-->
						<?php GridView::widget([
							'dataProvider' => $documentsProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
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
									'label' => 'Document Type',
									'attribute' => 'documentTypes.DocumentTypeName',
									'headerOptions' => ['width' => '15%'],
								],
								[
									'attribute' => 'CreatedDate',
									'format' => ['date', 'php:d/m/Y h:i a'],
									'headerOptions' => ['width' => '15%'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
									'template' => '{photo} {delete}',
									'buttons' => [
										'photo' => function($url, $model) use ($baseUrl) {								
											return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->Image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
										},
										'delete' => function ($url, $model) use ($rights) {
											return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
												'class' => 'btn-sm btn-danger btn-xs',
												'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('documents/delete?id=' . $model->DocumentID) . '", \'tab15\')',
											]) : '';
										},
									],
								],
							],
						]); ?>


                        <!-- Document Upload Preview   -->

                        <h4 class="form-section" style="margin-bottom: 0px">Document Uploads Preview</h4>

                        <?php if($document): ?>

                                 <iframe src="<?= $document ?>" height="700px" width="100%"></iframe>

                        <?php else: ?>
                            <p class="text">No Document to Preview</p>
                        <?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function() {

		$("#pdf-viewer").on("show.bs.modal", function(e) {
			var image = $(e.relatedTarget).data('image');
			var title = $(e.relatedTarget).data('title');
			$(".modal-body").html('<iframe src="'+  image +'" height="700px" width="100%"></iframe>');
			$(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">' + title + '</h4>');
		});
	});
</script>
