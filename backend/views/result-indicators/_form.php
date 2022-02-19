<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ResultIndicators */
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
					<?= $form->field($model, 'ResultIndicatorName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'IndicatorTypeID')->dropDownList($indicatorTypes, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Baseline')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '0.01']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'UnitOfMeasureID')->dropDownList($unitsOfMeasure, ['prompt'=>'Select']); ?>			
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">					
				</div>			
			</div>

			<h4 class="form-section" style="margin-bottom: 0px">Targets</h4>
			<table width="100%" class="custom-table table-bordered-min" id="ParameterTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important">Year</td>
				<td style="padding: 4px 4px 4px 4px !important">Target</td>
			</tr>	
			</thead>
			<?php 
			foreach ($targets as $x => $line) 
			{ ?>
				<tr>
					<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '[' . $x . ']ResultIndicatorTargetID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
					<td><?= $form->field($line, '[' . $x . ']Year', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'type' => 'number'])->label(false) ?></td>
					<td><?= $form->field($line, '[' . $x . ']Target', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'type' => 'number', 'step' => '0.01'])->label(false) ?></td>
					<td><?= Html::a('<i class="fa fa-edit mx-1"></i> Quarterly Targets',['./quarterly-targets','targetID'=> $line->ResultIndicatorTargetID],['class' => 'btn btn-success']) ?></td>

					
				</tr>
				<?php
			} ?>			
			</table>			
			<p></p>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
