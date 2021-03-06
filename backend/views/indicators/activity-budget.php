<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Activity Budget'

/* @var $this yii\web\View */
/* @var $model app\models\Indicators */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'budget', 'enableAjaxValidation' => true]); ?>

<!-- <h4 class="form-section">Activities</h4> -->
<table width="100%" class="custom-table" id="ColumnsTable">
<thead>
<tr>
	<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
	<td style="padding: 4px !important">Sub Activity</td>
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
		<td><?= $form->field($column, '[' . $x . ']Amount')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>					
	</tr>
	<?php
} ?>
</table>	 
<h4 class="form-section">Outputs</h4>
<table width="100%" class="custom-table" id="ColumnsTable">
<thead>
<tr>
	<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
	<td style="padding: 4px !important">Output</td>
</tr>	
</thead>
<?php
foreach ($output as $x => $column) {
	?>
	<tr>
		<td style="text-align: center;">
			<?= $x+1; ?>
			<?= $form->field($column, '[' . $x . ']ActivityOutputID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
		</td>
		<td><?= $form->field($column, '[' . $x . ']Output')->textInput(['class' => 'form-control'])->label(false) ?></td>
	</tr>
	<?php
} ?>
</table>

<div class="form-group">				
	<button type="button" class="btn btn-warning mr-1" data-dismiss="modal"><i class="ft-x"></i> Close</button>
	<button type="button" class="btn btn-primary mr-1" data-dismiss="modal" onclick="submitCurrentForm(<?= $id; ?>)"><i class="ft-tick"></i> Save</button>
</div>

<?php ActiveForm::end(); ?>
