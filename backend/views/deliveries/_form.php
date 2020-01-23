<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Deliveries */
/* @var $form yii\widgets\ActiveForm */

$Rights = Yii::$app->params['rights'];
$FormID = 15;
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
			<?php $form = ActiveForm::begin([
/* 			'id' => 'contact-form',
				'fieldConfig' => [
					'options' => ['tag' => false, ],
					'enableClientValidation'=> false,
					'enableAjaxValidation'=> false,
				], */
			]); 
			?>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'PurchaseID')->dropDownList($purchases, ['prompt'=>'Select...', 'disabled' => !$model->isNewRecord]) ?>
					<p></p>
					<?= $form->field($model, 'DeliveryNoteNumber')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 3]) ?>
				</div>			
			</div>
			<?php
			if (!$model->isNewRecord)
			{ ?>
				<table width="100%" class="custom-table table-striped table-bordered-min">
				<thead>
				<tr>
					<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
					<td style="padding: 4px 4px 4px 4px !important" width="15%">Code</td>
					<td style="padding: 4px 4px 4px 4px !important">Product</td>
					<td style="padding: 4px 4px 4px 4px !important" width="15%">Usage Unit</td>			
					<td style="padding: 4px 4px 4px 4px !important; text-align: right" width="15%">Ordered</td>
					<td style="padding: 4px 4px 4px 4px !important; text-align: right" width="15%">Received T.D.</td>
					<td style="padding: 4px 4px 4px 4px !important; text-align: right" width="15%">Delivered</td>
				</tr>	
				</thead>
				<?php 
				foreach ($lines as $x => $line) 
				{ 
					//print_r($data[$x]['Quantity']); exit;
					$disabled = false;
					$qtyDelivered = isset($delivered[$data[$x]['PurchaseLineID']]) ? $delivered[$data[$x]['PurchaseLineID']] : 0;
					if ($data[$x]['Quantity'] <= $qtyDelivered)
					{
						$disabled = true;
					}
					?>
					<tr>
						<td style="padding: 4px 4px 4px 4px !important; text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($line, '['.$x.']DeliveryLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($line, '['.$x.']PurchaseLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						</td>
						<td style="padding: 4px 4px 4px 4px !important"><?= $data[$x]['SupplierCode']; ?></td>
						<td style="padding: 4px 4px 4px 4px !important" ><?= $data[$x]['ProductName']; ?></td>
						<td style="padding: 4px 4px 4px 4px !important" ><?= $data[$x]['UsageUnitName']; ?></td>
						<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= $data[$x]['Quantity']; ?></td>
						<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= isset($delivered[$data[$x]['PurchaseLineID']]) ? $delivered[$data[$x]['PurchaseLineID']] : 0; ?></td>
						<td><?= $form->field($line, '['.$x.']DeliveredQuantity', ['template' => '{label}{input}'])->textInput(['class'=>'form-control-min', 'style'=>'text-align:right', 'disabled' => $disabled])->label(false) ?></td>
					</tr>
					<?php
				} ?>
				</table>
				<?php
			} ?>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
				
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>