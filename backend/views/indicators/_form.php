<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
			<?php $form = ActiveForm::begin(); ?>
	 
	 		<div class="row">
				<div class="col-md-12">
					<?= $form->field($model, 'IndicatorName')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ComponentID')->dropDownList($components, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'SubComponentID')->dropDownList($subComponents, ['prompt'=>'Select']); ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'UnitOfMeasureID')->dropDownList($unitsOfMeasure, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'BaseLine')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'EndTarget')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'MeansOfVerification')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ResponsibilityID')->dropDownList($projectTeams, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<h4 class="form-section">Targets</h4>
			<table width="100%" class="custom-table" id="ColumnsTable">
			<thead>
			<tr>
				<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px !important">Period</td>
				<td style="padding: 4px !important">Description</td>
				<td style="padding: 4px !important" width="15%">Target</td>
			</tr>	
			</thead>
			<?php
			foreach ($indicatorTargets as $x => $column) {
				?>
				<tr>
					<td style="text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($column, '[' . $x . ']IndicatorTargetID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($column, '[' . $x . ']ReportingPeriodID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td><?= $column->ReportingPeriodName; ?></td>
					<td><?= $form->field($column, '[' . $x . ']IndicatorTargetName')->textInput(['class' => 'form-control'])->label(false) ?></td>
					<td><?= $form->field($column, '[' . $x . ']Target')->textInput(['class' => 'form-control'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>	
			
			<h4 class="form-section">Activities</h4>
			<table width="100%" class="custom-table" id="ColumnsTable">
			<thead>
			<tr>
				<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px !important">Description</td>
				<td style="padding: 4px !important" width="10%">Start Date</td>
				<td style="padding: 4px !important" width="10%">End Date</td>
				<td style="padding: 4px !important" width="15%">Responsibility</td>
			</tr>	
			</thead>
			<?php
			foreach ($activities as $x => $column) {
				?>
				<tr>
					<td style="text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($column, '[' . $x . ']ActivityID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td><?= $form->field($column, '[' . $x . ']ActivityName')->textInput(['class' => 'form-control'])->label(false) ?></td>
					<td><?= $form->field($column, '[' . $x . ']StartDate')->textInput(['class' => 'form-control', 'type' => 'date'])->label(false) ?></td>
					<td><?= $form->field($column, '[' . $x . ']EndDate')->textInput(['class' => 'form-control', 'type' => 'date'])->label(false) ?></td>
					<td><?= $form->field($column, '[' . $x . ']ResponsibilityID', ['template' => '{label}{input}'])->dropDownList($employees, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>	 

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['projects/view', 'id' => $model->ProjectID], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
