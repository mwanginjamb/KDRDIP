<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Budget */
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
					<?= $form->field($model, 'FinancialPeriod')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>	
				</div>			
			</div>

			<h4 class="form-section" style="margin-bottom: 0px">Lines</h4>
			<table width="100%" class="custom-table" id="ColumnsTable">
			<thead>
			<tr>
				<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px !important" width="15%">Code</td>
				<td style="padding: 4px !important">Account Name</td>
				<td style="padding: 4px !important" width="15%">Amount</td>
			</tr>	
			</thead>
			<?php
			foreach ($budgetLines as $x => $column) {
				/* print '<pre>';
				print_r($column); exit; */
				?>
				<tr>
					<td style="text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($column, '[' . $x . ']BudgetLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($column, '[' . $x . ']AccountID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td><?= $column->AccountCode; ?></td>
					<td><?= $column->AccountName; ?></td>
					<td><?= $form->field($column, '[' . $x . ']Amount')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['projects/view', 'id' => $model->ProjectID], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
