<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Predictions */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
input[type="checkbox"] {
	margin-top: 8px;
	zoom: 1.5 !important;
}
</style>
<div class="card-content collapse show">
	<div class="card-body">

		<?php $form = ActiveForm::begin(); ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'RegionID')->dropDownList($regions, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'LeagueID')->dropDownList($leagues, ['prompt'=>'Select']); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'GameTime')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Teams')->textInput(['maxlength' => true]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'Prediction')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'FinalOutcome')->textInput(['maxlength' => true]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'Results')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<label class="control-label" for="predictions-prediction">Free</label>
					<?= $form->field($model, 'Free')->checkbox(['style' => 'input[type="checkbox"] {
    zoom: 1.5 !important;
}',
					'label'=>'',
					// 'labelOptions' => ['style' => 'padding :5px; '],
					]); ?>							
				</div>
			</div>

			<div class="form-actions">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
