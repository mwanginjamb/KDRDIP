<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Suppliers */
/* @var $form yii\widgets\ActiveForm */
//print_r($contacts); exit;
$baseUrl = Yii::$app->request->baseUrl;
$url = $baseUrl.'/suppliers/details?id='.$model->SupplierID;

$Rights = Yii::$app->params['rights'];
$FormID = 6;
?>

			<?php $form = ActiveForm::begin(); ?>
	 
	 		<div class="row">
				<div class="col-md-6">
				<?= $form->field($model, 'SupplierName')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'PostalAddress')->textInput() ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'PostalCode')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Town')->textInput() ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'CountryID')->dropDownList($country,['prompt'=>'Select...']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Telephone')->textInput() ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Mobile')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Email')->textInput() ?>		
				</div>			
			</div>

			<h4 class="form-section" style="margin-bottom: 0px">Contact Persons</h4>
			<table width="100%" class="custom-table" id="ColumnsTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important">Contact Name</td>
				<td style="padding: 4px 4px 4px 4px !important" width="20%">Designation</td>
				<!-- <td style="padding: 4px 4px 4px 4px !important" width="12%">Telephone</td> -->
				<td style="padding: 4px 4px 4px 4px !important" width="20%">Mobile</td>
				<td style="padding: 4px 4px 4px 4px !important" width="30%">Email</td>
			</tr>	
			</thead>
			<?php
			foreach ($contacts as $x => $contact) {
				?>
				<tr>
					<td style="text-align: center;">
						<?= $form->field($contact, '[' . $x . ']ContactName', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?>
						<?= $form->field($contact, '[' . $x . ']SupplierContactID', ['template' => '{label}{input}'])->hiddenInput(['class'=>'form-control'])->label(false);?>
					</td>
					<td><?= $form->field($contact, '[' . $x . ']Designation', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
					<!-- <td><?= $form->field($contact, '[' . $x . ']Telephone', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td> -->
					<td><?= $form->field($contact, '[' . $x . ']Mobile', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
					<td><?= $form->field($contact, '[' . $x . ']Email', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'PIN')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'VATNo')->textInput() ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'VATRate')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'CreditPeriod')->textInput() ?>		
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>


