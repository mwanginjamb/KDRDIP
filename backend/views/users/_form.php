<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
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
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'UserGroupID')->dropDownList($usergroups, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'UserStatusID')->dropDownList($userstatus, ['prompt'=>'Select']); ?>
				</div>
			</div>

			<?php if ($model->isNewRecord) {?>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'Password')->passwordInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ConfirmPassword')->passwordInput() ?>
				</div>
			</div>
			<?php } ?>

			<div class="form-actions">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
