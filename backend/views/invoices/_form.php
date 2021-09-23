<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$baseModel = $model;
$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */
/* @var $form yii\widgets\ActiveForm */
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
					<?= $form->field($model, 'SupplierID')->dropDownList($suppliers, ['prompt'=>'Select...', 
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('invoices/purchases?id=') . '"+$(this).val(), function( data ) {

							$( "select#invoices-purchaseid" ).html( data );
						});
					']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'PurchaseID')->dropDownList($purchases, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt'=>'Select...', 'class' => 'form-control select2',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('invoices/procurement-plan-activities?id=') . '"+$(this).val(), function( data ) {

							$( "select#invoices-procurementplanlineid" ).html( data );
						});
					']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ProcurementPlanLineID')->dropDownList($procurementPlanLines, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'InvoiceNumber')->textInput(['type' => 'text']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'InvoiceDate')->textInput(['type' => 'date']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Amount')->textInput(['maxlength' => true, 'type' => 'number']) ?>
				</div>
				<div class="col-md-6">
					
				</div>			
			</div>

			<h4 class="form-section">Supporting Document</h4>
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
						'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
						'template' => '{view} {delete}',
						'buttons' => [
	
							'view' => function ($url, $model) use ($rights, $baseModel) {
								return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view-document', 'id' => $model->DocumentID, 'InvoiceID' => $baseModel->InvoiceID], ['class' => 'btn-sm btn-primary']) : '';
							},
							'delete' => function ($url, $model) use ($rights, $baseModel) {
								return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Remove', ['delete-document', 'id' => $model->DocumentID, 'InvoiceID' => $baseModel->InvoiceID], [
									'class' => 'btn-sm btn-danger btn-xs',
									'data' => [
										'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
										'method' => 'post',
									],
								]) : '';
							},
						],
					],
				],
			]); ?>
			<h4 class="form-section">Attach Supporting Document</h4>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'imageFile')->fileInput(['style' => 'margin-top: 25px']) ?>
				</div>			
			</div>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Description2')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'imageFile2')->fileInput(['style' => 'margin-top: 25px']) ?>
				</div>			
			</div>		

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	 </div>
</div>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script src="<?= $baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>