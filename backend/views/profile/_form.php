<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content collapse show">
	<div class="card-body">

		<?php $form = ActiveForm::begin(); ?>

		<div class="row">
			<div class="col-md-6">					
				<?= $form->field($model, 'FirstName')->textInput(['maxlength' => true, 'class' =>'form-control square']) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true, 'class' =>'form-control square']) ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">					
				<?= $form->field($model, 'LastName')->textInput(['maxlength' => true, 'class' =>'form-control square']) ?>
			</div>
			<div class="col-md-6">
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">		
				<div class="form-group field-profiles-mobile">
					<label class="control-label" for="profiles-mobile">Country Code</label>
					<div class="disabled-field"><?= $model->countries->Code; ?></div>
					<div class="help-block"></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group field-profiles-mobile">
					<label class="control-label" for="profiles-mobile">Mobile</label>
					<div class="disabled-field"><?= $model->Mobile; ?></div>
					<div class="help-block"></div>
				</div>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'Email')->textInput(['maxlength' => true, 'class' =>'form-control square']) ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">					
				<?= $form->field($model, 'ProfileStatusID')->dropDownList($profilestatus, ['prompt'=>'Select', 'class' =>'form-control square']); ?>
			</div>
			<div class="col-md-6">
				
			</div>
		</div>

	 	<div class="form-actions">
			<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
			<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
</div>
