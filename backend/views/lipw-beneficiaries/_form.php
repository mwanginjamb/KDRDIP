<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */
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
			<?= $form->field($model, 'HouseholdID')->hiddenInput()->label(false); ?>
	 
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true]) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'DateOfBirth')->textInput(['type' => 'date']) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'BeneficiaryTypeID')->dropDownList($beneficiaryTypes, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<label for="lipwbeneficiaries-principal" style="display: block;">Principal</label>
					<?= Html::activeCheckbox($model, 'Principal', ['class' => 'form-control', 'label' => '', 'style' => 'width: 20px; margin-top: 20px']); ?>
				</div>			
			</div>			
			
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Gender')->dropDownList($gender, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'IDNumber')->textInput(['maxlength' => true]) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'AlternativeID')->dropDownList($beneficiaries, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'BankAccountNumber')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'BankAccountName')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'BankID')->dropDownList($banks, ['prompt' => 'Select...', 'class' => 'form-control',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('banks/branches?id=') . '"+$(this).val(), function( data ) {

							$( "select#lipwbeneficiaries-bankbranchid" ).html( data );
						});
					']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'BankBranchID')->dropDownList($bankBranches, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/index?hId=' . $model->HouseholdID) . '", \'tab2\')']) ?>
				<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'lipw-beneficiaries/create?1=1' : 'lipw-beneficiaries/update?id=' . $model->BeneficiaryID) . '",\'tab2\',\'currentForm\', \'saveBtn\')']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
