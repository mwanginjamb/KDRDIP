<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$url = Url::home(true);

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlan */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'New Activity';
?>
<style>
#ParameterTable .form-group {
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	/* */
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
	 
				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'ServiceDescription')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-md-6">		
						<?= $form->field($model, 'UnitOfMeasureID')->dropDownList($unitsOfMeasure, ['prompt'=>'Select...']) ?>		
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'Quantity')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '0.01']) ?>
					</div>
					<div class="col-md-6">		
						<?= $form->field($model, 'ProcurementMethodID')->dropDownList($procurementMethods, ['prompt'=>'Select...']) ?>			
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'SourcesOfFunds')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-md-6">
						<?= $form->field($model, 'EstimatedCost')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '0.01']) ?>	
					</div>			
				</div>	

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'ActualCost')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '0.01']) ?>
					</div>
					<div class="col-md-6">	
					</div>			
				</div>

				<div class="form-group">
					<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/view?id=' . $model->ProcurementPlanID) . '", \'tab22\')']) ?>
					<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'style' => 'color: white', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl('procurement-plan/line-create?pId=' . $model->ProcurementPlanID) . '",\'tab22\',\'currentForm\', \'saveBtn\')']) ?>
				</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
