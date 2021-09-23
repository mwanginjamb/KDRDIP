<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

switch ($model->ApprovalStatusID) {
	case 1:
		$this->title = 'Cash Disbursement Review:';
		break;
	case 2:
		$this->title = 'Cash Disbursement Approvals:';
		break;
	case 3:
		$this->title = 'Cash Disbursement Approved:';
		break;
	case 4:
		$this->title = 'Cash Disbursement Rejected:';
		break;
	default:
		$this->title = 'Cash Disbursement Review:';
}
$this->title = $this->title . ' ' . $model->CashDisbursementID;
$this->params['breadcrumbs'][] = $this->title;

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
						<div class="row">
							<div class="col-lg-5">
								<p>Enter Approval details below</p>
							<?php $form = ActiveForm::begin(); ?>
							<?= $form->field($notes, 'Note')->textarea(['rows' => 3]) ?>
							<input type="hidden" id="option" name="option" value="<?= $option; ?>">
							<?php // $form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

							<div class="form-group">
								<?= Html::a('<i class="ft-x"></i> Close', ['index', 'option' => $option], ['class' => 'btn btn-warning mr-1']) ?>
								<?= Html::submitButton('<i class="ft-check"></i> Approve', ['class' => 'btn btn-success', 'name'=>'Approve']);?>
								<?= Html::submitButton('<i class="ft-x"></i> Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']); ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $model,
								'attributes' => [
									'CashDisbursementID',
									'DisbursementDate',
									'SerialNumber',
									'counties.CountyName',
									'organizations.OrganizationName',
									'projects.ProjectName',
                                    'counties.CountyName',
                                    'disbursementTypes.DisbursementTypeName',
									'Description:ntext',
									[
										'attribute' => 'sourceBankAccount.AccountName',
										'label' => 'Source Account', 
									],
									[
										'attribute' => 'destinationBankAccount.AccountName',
										'label' => 'Destination Account', 
									],	
									[
										'attribute' => 'Amount',
										'format' => ['decimal', 2],
									],
									[
										'attribute' => 'CreatedDate',
										'format' => ['date', 'php:d/m/Y h:i a'],									
									],
									[
										'label' => 'Created By',
										'attribute' => 'users.fullName',
									],
									[
										'attribute' => 'CreatedDate',
										'label' => 'Created Date',
										'format' => ['date', 'php:d/m/Y h:i a'],
									],									
									[
										'label'=>'Approval Status',
										'attribute' => 'approvalstatus.ApprovalStatusName',
									],
									[
										'label' => 'Approved By',
										'attribute' => 'approvedByusers.fullName',
									],
									[
										'label'=>'Approved Date',
										'format' => ['date', 'php:d/m/Y h:i a'],
										'attribute' => 'ApprovalDate',
									]								
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

						<h4 class="form-section" style="margin-bottom: 0px">Documents</h4>					
						<?= GridView::widget([
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
