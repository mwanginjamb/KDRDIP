<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LipwWorkRegister */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
#ParameterTable .form-group {
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	/* padding: 4px !important; */
}
</style>
<div class="card">
	<div class="card-header1">
		<h4 class="form-section">Daily Attendance Register</h4>
	</div>
	<div class="card-content collapse show">
		<div class="card-body">
			<?php $form = ActiveForm::begin(['id' => 'currentForm']); ?>
			<?= $form->field($header, 'MasterRollID')->hiddenInput()->label(false); ?>

			<div class="row">
				<div class="col-md-2">
					<?= $form->field($header, 'Date')->textInput(['type' => 'date']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($header, 'ProjectID')->dropDownList($projects, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<h4 class="form-section">Beneficiaries</h4>												
			<table width="100%" class="custom-table table-striped table-bordered" id="ParameterTable" >
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important">Beneficiary</td>
				<td style="padding: 4px 4px 4px 4px !important; text-align: right;" width="15%">Rate</td>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="15%">Worked</td>
			</tr>	
			</thead>
			<tbody>
			<?php
			foreach ($lines as $x => $line) {?>
				<tr>
					<td style="padding: 0px 4px !important; text-align: center;" width="5%"><?= $x + 1; ?>
						<?= $form->field($line, '[' . $x . ']BeneficiaryID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($line, '[' . $x . ']WorkRegisterID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
						<?= $form->field($line, '[' . $x . ']Rate', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td style="padding: 0px 4px !important"><?= $line['BeneficiaryName']; ?></td>
					<td style="padding: 0px 4px !important; text-align: right;"><?= $line['Rate']; ?></td>
					<td style="padding: 0px 4px !important; text-align: center"><?= $form->field($line, '[' . $x . ']Worked')->radioList([1 => 'Yes', 2 => 'No'], ['unselect' => null], ['item' => 'style="margin-bottom: 0px"']); ?></td>
				</tr>
				<?php
			} ?>
			</tbody>
			</table>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-work-register/index?mId=' . $model->MasterRollID) . '", \'tab3\')']) ?>
				<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl($model->isNewRecord ? 'lipw-work-register/create?1=1' : 'lipw-work-register/update?id=' . $model->WorkRegisterID) . '",\'tab3\',\'currentForm\')']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
