<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectBeneficiaries */
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
			<?php $form = ActiveForm::begin(['id' => 'currentForm']); ?>
			<?= $form->field($model, 'ProjectID')->hiddenInput()->label(false); ?>
	 
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt' => 'Select...', 'class' => 'form-control',
											'onchange' => '
											$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {

												$( "select#projectbeneficiaries-subcountyid" ).html( data );
											});
										']) ?>	
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'SubCountyID')->dropDownList($subCounties, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'HostPopulationMale')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">					
					<?= $form->field($model, 'HostPopulationFemale')->textInput(['type' => 'number']) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'RefugeePopulationMale')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">					
					<?= $form->field($model, 'RefugeePopulationFemale')->textInput(['type' => 'number']) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'MinorityClans')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6"></div>
			</div>

            <div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Women')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">					
					<?= $form->field($model, 'Men')->textInput(['type' => 'number']) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Youth')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Minority')->textInput(['type' => 'number']) ?>
				</div>
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-beneficiaries/index?pId=' . $model->ProjectID) . '", \'tab6\')']) ?>
				<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'project-beneficiaries/create?pId=' . $model->ProjectID : 'project-beneficiaries/update?id=' . $model->ProjectBeneficiaryID) . '",\'tab6\',\'currentForm\', \'saveBtn\')']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
