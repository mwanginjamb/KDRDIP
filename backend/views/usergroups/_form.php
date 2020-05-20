<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroups */
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
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	 
	 		<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'UserGroupName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 2]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>

			
			<h4 class="form-section">Permissions</h4>
			<table width="100%" class="custom-table table-striped table-bordered zero-configuration1">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center; font-weight: bold" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important; font-weight: bold">Form</td>
				<td style="padding: 4px 4px 4px 4px !important; text-align:center; font-weight: bold" width="15%">View</td>
				<td style="padding: 4px 4px 4px 4px !important; text-align:center; font-weight: bold" width="15%">Insert</td>
				<td style="padding: 4px 4px 4px 4px !important; text-align:center; font-weight: bold" width="15%">Edit</td>
				<td style="padding: 4px 4px 4px 4px !important; text-align:center; font-weight: bold" width="15%">Delete</td>
			</tr>	
			</thead>
			<?php
			foreach ($lines as $x => $line) 
			{
				?>
				<?= $form->field($line, '['.$x.']UserGroupRightID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
				<?= $form->field($line, '['.$x.']PageID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
				<tr>
					<td style="padding: 4px 4px 4px 4px !important; text-align: center;">
						<?= $x+1; ?>
					</td>						
					<td style="padding: 4px 4px 4px 4px !important;"><?= $line['PageName']; ?></td>
					<td style="text-align:center;"><?= $form->field($line, '['.$x.']View', ['template' => '{label}{input}', 'options' => ['style'=>'margin-bottom: 0 !important;']])->checkBox()->label(false) ?></td>
					<td style="text-align:center;"><?= $form->field($line, '['.$x.']Create', ['template' => '{label}{input}', 'options' => ['style'=>'margin-bottom: 0 !important;']])->checkBox()->label(false) ?></td>
					<td style="text-align:center;"><?= $form->field($line, '['.$x.']Edit', ['template' => '{label}{input}', 'options' => ['style'=>'margin-bottom: 0 !important;']])->checkBox()->label(false) ?></td>
					<td style="text-align:center;"><?= $form->field($line, '['.$x.']Delete', ['template' => '{label}{input}', 'options' => ['style'=>'margin-bottom: 0 !important;']])->checkBox()->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
