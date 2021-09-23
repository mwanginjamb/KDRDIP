<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Disbursement */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	.btn-primary {
		color: #FFFFFF !important;
	}

	.btn-warning {
		color: #FFFFFF !important;
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
			<?php $form = ActiveForm::begin(['id' => 'currentForm']); ?>
			<?= $form->field($model, 'EnterpriseID')->hiddenInput()->label(false); ?>
			<?= $form->field($model, 'EnterpriseTypeID')->hiddenInput()->label(false); ?>
			<div class="row">
				<div class="col-md-3">
					<?= $form->field($model, 'Quarter')->textInput(['maxlength' => true, 'type' => 'number']) ?>
				</div>
				<div class="col-md-3">
					<?= $form->field($model, 'Year')->textInput(['maxlength' => true, 'type' => 'number']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Date')->textInput(['type' => 'date']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Amount')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '0.01']) ?>
				</div>
				<div class="col-md-6">
					
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('disbursement/index?eId=' . $model->EnterpriseID) . '", \'tab3\')']) ?>
				<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'disbursement/create?eId=' . $model->EnterpriseID : 'disbursement/update?id=' . $model->DisbursementID) . '",\'tab3\',\'currentForm\', \'saveBtn\')']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
