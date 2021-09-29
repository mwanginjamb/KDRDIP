<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrganizationTrainings */
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
			<?= $form->field($model, 'OrganizationID')->textInput(['readonly' => true]); ?>
	 
			<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'Date')->textInput(['type' => 'date']) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>	
				</div>			
			</div>

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'TrainingTypeId')->dropDownList($trainingTypes, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'TotalAttendees')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'Facilitator')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'Agenda')->textarea(['rows' => 6]) ?>
				</div>
				<div class="col-md-6">
                    
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('organization-trainings/index?oId=' . $model->OrganizationID) . '", \'tab4\')']) ?>
				<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'organization-trainings/create?oId=' . $model->OrganizationID : 'organization-trainings/update?id=' . $model->OrganizationTrainingID) . '",\'tab4\',\'currentForm\', \'saveBtn\')']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
