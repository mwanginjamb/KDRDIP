<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\StoreRequisition */
/* @var $form yii\widgets\ActiveForm */

$url = Url::home(true);
$disabled = !$model->isNewRecord;
?>
<script>
function addRow() 
{
	var table = document.getElementById("RequisitionTable");
	var rows = table.getElementsByTagName("tr").length;
	var row = table.insertRow(rows);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	
	var fields = fetch_data1('<?= $url; ?>/requisition/getfields?id='+rows+'&StoreID=<?= $model->StoreID; ?>');
	//console.log(fields);
	cell1.innerHTML = fields[0];
	cell2.innerHTML = fields[1];
	cell3.innerHTML = fields[2];
	cell4.innerHTML = fields[3];
	cell1.style.textAlign = 'center';
}
</script>

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
			'id' => 'contact-form',
				'fieldConfig' => [
					'options' => ['tag' => false, ],
					'enableClientValidation'=> false,
					'enableAjaxValidation'=> false,
				],
			]); 
			?>
			<table width="100%">
			<tr> 
				<td width="50%"><?= $form->field($model, 'StoreID')->dropDownList($stores, ['prompt'=>'Select...', 'disabled' => $disabled]) ?></td>
				<td>
					
				</td>
			</tr>	
			</table>
			<?php
			if (!$model->isNewRecord)
			{ ?>
				<table width="100%" class="custom-table table-striped table-bordered-min" id="RequisitionTable">
				<thead>
				<tr>
					<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
					<td style="padding: 4px 4px 4px 4px !important">Product</td>
					<td style="padding: 4px 4px 4px 4px !important" width="15%">Quantity</td>
					<td style="padding: 4px 4px 4px 4px !important" width="45%">Description</td>
				</tr>	
				</thead>
				<?php 
				foreach ($lines as $x => $line) 
				{ ?>
					<tr>
						<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '[' . $x . ']RequisitionLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
						<td><?= $form->field($line, '[' . $x . ']ProductID', ['template' => '{label}{input}'])->dropDownList($products, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']Quantity', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']Description', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>			
					</tr>
					<?php
				} ?>
				</table>
				<?php
			} ?>
			<table width="100%">
			<tr> 
				<td width="50%"></td>
				<td valign="top" style="text-align:right"><?= (!$model->isNewRecord) ? Html::button('Add Row', [ 'class' => 'bigbtn btn-primary', 'onclick' => 'addRow()' ]) : ''; ?></td>
			</tr>
			</table>
			<table width="100%">
			<tr> 
				<td width="50%"><?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?></td>
				<td>
					<div class="form-group">
						<label class="control-label">Created By</label>
						<input type="text" class="form-control" value="<?= $users->fullName; ?>" disabled style="background:white">
						<div class="help-block"></div>
					</div>
					<div class="form-group">
						<label class="control-label">Created Date</label>
						<input type="text" class="form-control" value="<?= $model->CreatedDate; ?>" disabled style="background:white">
						<div class="help-block"></div>
					</div>
				</td>
			</tr>
			</table>
			<p></p>
			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
				<?php
				if (!$model->isNewRecord) {
					echo Html::a('Submit', ['submit', 'id' => $model->StoreRequisitionID], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => 'Are you sure you want to submit this item?',
						'method' => 'post',
					],
				]); 
				} ?>
			</div>

		<?php ActiveForm::end(); ?>

	</div>
</div>