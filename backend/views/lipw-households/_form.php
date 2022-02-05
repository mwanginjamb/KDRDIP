<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LipwHouseholds */
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

			<?= $form->errorSummary($model) ?>
	 
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'HouseholdName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt' => 'Select...', 'class' => 'form-control',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {

							$( "select#lipwhouseholds-subcountyid" ).html( data );
						});
					']) ?>
				</div>			
			</div>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'SubCountyID')->dropDownList($subCounties, ['prompt' => 'Select...', 'class' => 'form-control',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('projects/locations?id=') . '"+$(this).val(), function( data ) {

							$( "select#lipwhouseholds-locationid" ).html( data );
						});
					']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'LocationID')->dropDownList($locations, ['prompt' => 'Select...', 'class' => 'form-control',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-locations?id=') . '"+$(this).val(), function( data ) {

							$( "select#lipwhouseholds-sublocationid" ).html( data );
						});
					']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'SubLocationID')->dropDownList($subLocations, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'TotalBeneficiaries')->textInput(['type' => 'number']) ?>				
				</div>			
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'mpesa_account_no')->textInput(['type' => 'number']) ?>				
					
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
