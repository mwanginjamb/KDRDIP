<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationResponse */
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
					<?= $form->field($model, 'Description')->textInput() ?>
				</div>
				<div class="col-md-6">
					
				</div>			
			</div>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ResponseDate')->textInput(['type' => 'date']) ?>
				</div>
				<div class="col-md-6">
					
				</div>			
			</div>
			

			<h4 class="form-section" style="margin-bottom: 0px">Quotation Details</h4>
			<div class="row">
				<div class="col-md-3">
					Quotation No.
				</div>
				<div class="col-md-3">
					<?= $quotation->QuotationID ;?>
				</div>			
			</div>
			<div class="row">
				<div class="col-md-3">
					Supplier Name
				</div>
				<div class="col-md-3">
					<?= $supplier->SupplierName ;?>
				</div>			
			</div>
			
			

			<h4 class="form-section" style="margin-bottom: 0px">Select Products</h4>
			<table width="100%" class="custom-table table-bordered-min" id="ProductTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important">Product</td>
				<td style="padding: 4px 4px 4px 4px !important" width="15%">Quantity</td>
				<td style="padding: 4px 4px 4px 4px !important" width="15%">Unit Price</td>
			</tr>	
			</thead>
			<?php 
			foreach ($lines as $x => $line) { ?>
				<tr>
					<td style="text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($line, '[' . $x . ']QuotationResponseLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($line, '[' . $x . ']QuotationResponseID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($line, '[' . $x . ']QuotationProductID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td><?= $line->product->ProductName; ?></td>	
					<td><?= $line['Quantity']; ?></td>					
					<td><?= $form->field($line, '[' . $x . ']UnitPrice', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'type' => 'number'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>

			<div class="form-actions" style="margin-top:0px">
				<?= Html::a('<i class="ft-x"></i> Close', ['quotation/view', 'id' => $model->QuotationID], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
