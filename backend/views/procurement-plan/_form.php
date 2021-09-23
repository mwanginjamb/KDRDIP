<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$url = Url::home(true);

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlan */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
#ParameterTable .form-group {
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	/* */
}

#ParameterTable td, th {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
}

.custom-form-control, .custom-select, .form-control-file {
    background-clip: padding-box;
    background-color: transparent;
    border-color: rgba(0, 0, 0, 0.3);
    border-radius: 0;
    border-style: solid;
    border-width: 0 0 1px;
    -webkit-box-shadow: none;
    box-shadow: none;
    color: rgba(0, 0, 0, 0.87);
    display: block;
    font-size: 1rem;
    line-height: 2.5;
    /* padding: 0.2rem 1rem -webkit-calc(0.2rem - 1px);
    padding: 0.2rem 1rem -moz-calc(0.2rem - 1px);
    padding: 0.2rem 1rem calc(0.2rem - 1px); */
    width: 100%;
}
</style>
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
			<?php $form = ActiveForm::begin(['id' => 'currentForm', 'enableAjaxValidation' => true]); ?>
				<?= $form->field($model, 'ProjectID')->hiddenInput()->label(false); ?>
	 
				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'FinancialYear')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-md-6">					
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'Comments')->textarea(['rows' => 2]) ?>
					</div>
					<div class="col-md-6">	
						
					</div>			
				</div>

				<h4 class="form-section">Lines</h4>												
				<table width="100%" class="custom-table table-striped table-bordered" id="ParameterTable" >
				<thead>
				<tr>
					<td style="text-align: center;" width="5%">#</td>
					<td width="20%">Activity Description</td>
					<td style="text-align: right;" width="10%">Unit</td>
					<td style="text-align: right;" width="10%">Quantity</td>
					<td style="text-align: left;" width="15%">Method</td>	
					<td style="text-align: left;" width="15%">Funding Source</td>	
					<td style="text-align: right;" width="10%">Cost Estimate</td>
					<td style="text-align: right;" width="10%">Actual Cost</td>
					<td style="text-align: center;" width="5%"></td>
				</tr>	
				</thead>
				<tbody>
				<?php
				foreach ($lines as $x => $line) { ?>
					<tr>
						<td><?= $x + 1; ?>
							<?= $form->field($line, '[' . $x . ']ProcurementPlanLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							<?= $form->field($line, '[' . $x . ']ProcurementPlanID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						</td>
						<td><?= $form->field($line, '[' . $x . ']ServiceDescription')->textInput(['class' => 'form-control'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']UnitOfMeasureID', [])->dropDownList($unitsOfMeasure, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']Quantity')->textInput(['class' => 'form-control', 'style' => 'text-align: right'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']ProcurementMethodID', [])->dropDownList($procurementMethods, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']SourcesOfFunds')->textInput(['class' => 'form-control'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']EstimatedCost')->textInput(['class' => 'form-control', 'style' => 'text-align: right'])->label(false) ?></td>
						<td><?= $form->field($line, '[' . $x . ']ActualCost')->textInput(['class' => 'form-control', 'style' => 'text-align: right'])->label(false) ?></td>
						<td><?= ($line->ProcurementPlanLineID) ? Html::a('<i class="ft-trash"></i>', null, [
							'class' => 'btn-sm btn-danger f-white',
							'onclick' => 'removeOneRow("' . Yii::$app->urlManager->createUrl('purchases/delete-line?id=' . $line->ProcurementPlanLineID) . '",' . $x . ')',
							]) : Html::a('<i class="ft-minus"></i>', null, ['class' => 'btn-sm btn-warning f-white', 'onclick' => 'removeRow(' . $x . ')' ]) ?></td>
					</tr>	
					<?php
				} ?>
				</tbody>
				</table>
				<table width="100%">
				<tr>
					<td colspan="5" align="right"><?= Html::a('<i class="ft-plus"></i>', null, ['class' => 'btn btn-warning', 'onclick' => 'addRow("' . $model->ProcurementPlanID .'")' ]) ?></td>
				</tr>
				</table>		

				<div class="form-group">
					<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/index?pId=' . $model->ProjectID) . '", \'tab22\')']) ?>
					<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'style' => 'color: white', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'procurement-plan/create?pId=' . $model->ProjectID : 'procurement-plan/update?id=' . $model->ProcurementPlanID) . '",\'tab22\',\'currentForm\', \'saveBtn\')']) ?>
				</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
