<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CashBook */
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
					<?= $form->field($model, 'Date')->textInput(['maxlength' => true, 'type' => 'date']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'DocumentReference')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt' => 'Select...', 'class' => 'form-control',
													'onchange' => '
													$.post( "' . Yii::$app->urlManager->createUrl('projects/communities?id=') . '"+$(this).val(), function( data ) {
														$( "select#cashbook-communityid" ).html( data );
													});
												']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'CommunityID')->dropDownList($communities, ['prompt' => 'Select...', 'class' => 'form-control',
													'onchange' => '
													$.post( "' . Yii::$app->urlManager->createUrl('cash-book/bank-accounts?communityId=') . '"+$(this).val()+ "&countyId="+$("#cashbook-countyid").val(), function( data ) {
														$( "select#cashbook-accountid" ).html( data );
													});
													$.post( "' . Yii::$app->urlManager->createUrl('cash-book/projects?communityId=') . '"+$(this).val() + "&countyId="+$("#cashbook-countyid").val(), function( data ) {
														$( "select#cashbook-projectid" ).html( data );
													});
												']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt' => 'Select...', 'class' => 'form-control',
													'onchange' => '
													$.post( "' . Yii::$app->urlManager->createUrl('projects/disbursements?id=') . '"+$(this).val(), function( data ) {
														$( "select#cashbook-projectdisbursementid" ).html( data );
													});
												']) ?>
					
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ProjectDisbursementID')->dropDownList($projectDisbursements, ['prompt'=>'Select']); ?>
				</div>			
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'AccountID')->dropDownList($bankAccounts, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Amount')->textInput(['maxlength' => true, 'type' => 'number']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Description')->textarea(['rows' => 4]) ?>					
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['bank-accounts/view', 'id' => $baid], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
