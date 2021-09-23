<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
	'header' => '<h4 class="modal-title">Document</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'pdf-viewer',
	'size' => 'modal-lg',
	]);

Modal::end();
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
			<?php $form = ActiveForm::begin(); ?>
				 
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Date')->textInput(['type' => 'date']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'BankAccountID')->dropDownList($bankAccounts, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'PaymentTypeID')->dropDownList($paymentTypes, ['prompt'=>'Select...',
					'onchange' => '									
						if ($(this).val() == 1) {		
							$("#supplier").show();
						} else {
							$("#supplier").hide();
						}
					']) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt'=>'Select...', 'class' => 'select2',
					'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('payments/procurement-plan-lines?id=') . '"+$(this).val(), function( data ) {

							$( "select#payments-procurementplanlineid" ).html( data );
						});
					']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ProcurementPlanLineID')->dropDownList($procurementPlanLines, ['prompt'=>'Select...']) ?>
				</div>			
			</div>
	 
	 		<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'Supplier')->textInput() ?>
				</div>
				<div class="col-md-6">
				</div>			
			</div>

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'InvoiceNumber')->textInput() ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'InvoiceDate')->textInput(['type' => 'date']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'PaymentMethodID')->dropDownList($paymentMethods, ['prompt'=>'Select...']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'RefNumber')->textInput(['type' => 'text']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Amount')->textInput(['maxlength' => true, 'type' => 'number']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'imageFile')->fileInput() ?>
				</div>
				<div class="col-md-6">
				</div>			
			</div>		

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>
			<h4 class="form-section">Documents</h4>	
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
<script src="<?= $baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>
