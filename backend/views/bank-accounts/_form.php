<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		manageType()
	});

	function manageType() {
		var typeid = document.getElementById("bankaccounts-banktypeid").value;
		if (typeid == 1) {
			$("#countyList").hide();
			$("#organizationList").hide();
			$("#projectList").hide();
		} else if (typeid == 2) {
			$("#countyList").show();
			$("#organizationList").hide();
			$("#projectList").hide();
		} else if (typeid == 3) {
			$("#countyList").show();
			$("#organizationList").show();
			$("#projectList").hide();
		} else if (typeid == 4) {
			$("#countyList").show();
			$("#projectList").show();
			$("#organizationList").hide();
		} else {
			$("#countyList").hide();
			$("#organizationList").hide();
			$("#projectList").hide();
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

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'AccountNumber')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'AccountName')->textInput(['maxlength' => true]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'BankID')->dropDownList($banks, [
						'prompt' => 'Select...',
						'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('bank-accounts/branches?id=') . '" + $(this).val(), function( data ) {
						$( "select#bankaccounts-branchid" ).html( data );
					});
					'
					]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'BranchID')->dropDownList($bankBranches, ['prompt' => 'Select...']) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'BankTypeID')->dropDownList($bankTypes, [
						'prompt' => 'Select...',
						'onchange' => 'manageType()'
					]) ?>
				</div>
				<div class="col-md-6" id="countyList">
					<?= $form->field($model, 'CountyID')->dropDownList($counties, [
						'prompt' => 'Select...', 'class' => 'form-control select2',
						'onchange' => '
                        $.post( "' . Yii::$app->urlManager->createUrl('counties/projects?id=') . '"+$(this).val(), function( data ) {
                            $( "select#bankaccounts-projectid" ).html( data );
                        });
                        $.post( "' . Yii::$app->urlManager->createUrl('counties/organizations?id=') . '"+$(this).val(), function( data ) {
                            $( "select#bankaccounts-organizationid" ).html( data );
                        });
                    '
					]) ?>
				</div>
				<div class="col-md-6" id="organizationList">
					<?= $form->field($model, 'OrganizationID')->dropDownList($organizations, ['prompt' => 'Select...']) ?>
				</div>
				<div class="col-md-6" id="projectList">
					<?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt' => 'Select...']) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>
				</div>
				<div class="col-md-6">
				</div>
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

<?php
$script = <<<JS
$('#bankaccounts-projectid,#bankaccounts-organizationid').select2();
JS;

$this->registerJs($script, \yii\web\View::POS_END);
