<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$( document ).ready(function() {
		manageType()
	});

	function manageType() {
		var typeid = document.getElementById("users-usertypeid").value;
		if (typeid == 1) {
			$("#countyList").hide();
			$("#communityList").hide();
		} else if (typeid == 2) {
			$("#countyList").show();
			$("#communityList").hide();
		} else if (typeid == 3) {
			$("#countyList").show();
			$("#communityList").show();
		} else {
			$("#countyList").hide();
			$("#communityList").hide();
		}
	}

</script>
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
			
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'UserTypeID')->dropDownList($userTypes, ['prompt'=>'Select...',
					'onchange' => 'manageType()']) ?>
				</div>
				<div class="col-md-6" id="countyList">
					<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<div class="row" id="communityList">
				<div class="col-md-6">					
					<?= $form->field($model, 'CommunityID')->dropDownList($communities, ['prompt'=>'Select...']) ?>
				</div>
				<div class="col-md-6">
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
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
