<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Components */
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
					<?= $form->field($model, 'ComponentName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ShortName')->textInput(['maxlength' => true]) ?>				
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>
			
			<h4 class="form-section" style="margin-bottom: 0px">Sub Components</h4>
			<table width="100%" class="custom-table" id="ColumnsTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important">Sub Component</td>
			</tr>	
			</thead>
			<?php
			foreach ($subComponents as $x => $column) {
				?>
				<tr>
					<td style="text-align: center;">
						<?= $x+1; ?>
						<?= $form->field($column, '[' . $x . ']SubComponentID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					</td>
					<td><?= $form->field($column, '[' . $x . ']SubComponentName')->textInput(['class' => 'form-control'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
