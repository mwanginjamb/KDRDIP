<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Activity Budget'

/* @var $this yii\web\View */
/* @var $model app\models\Indicators */
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
			<?php $form = ActiveForm::begin(['id' => 'budget', 'enableAjaxValidation' => true]); ?>
			
			<h4 class="form-section">Activities</h4>
			<table width="100%" class="custom-table" id="ColumnsTable">
			<thead>
			<tr>
				<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px !important">Description</td>
				<td style="padding: 4px !important" width="20%">Account</td>
				<td style="padding: 4px !important" width="15%">Amount</td>
			</tr>	
			</thead>
			<?php
			foreach ($budget as $x => $column) {
				?>
				<tr>
					<td style="text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($column, '[' . $x . ']ActivityBudgetID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td><?= $form->field($column, '[' . $x . ']Description')->textInput(['class' => 'form-control'])->label(false) ?></td>
					<td><?= $form->field($column, '[' . $x . ']AccountID', ['template' => '{label}{input}'])->dropDownList($accounts, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
					<td><?= $form->field($column, '[' . $x . ']Amount')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>					
				</tr>
				<?php
			} ?>
			</table>	 

			<div class="form-group">				
				<button type="button" class="btn btn-warning mr-1" data-dismiss="modal"><i class="ft-x"></i> Cancel</button>
				<button type="button" class="btn btn-primary mr-1" data-dismiss="modal" onclick="submitForm(<?= $id; ?>)"><i class="ft-tick"></i> Save</button>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
