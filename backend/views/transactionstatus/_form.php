<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionStatus */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card-content collapse show">
	<div class="card-body">

		<?php $form = ActiveForm::begin(); ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'TransactionStatusName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">					
					<?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>
				</div>
				<div class="col-md-6">
					
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
