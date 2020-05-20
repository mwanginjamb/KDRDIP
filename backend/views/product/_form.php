<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$Rights = Yii::$app->params['rights'];
$FormID = 1;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
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
					<?= $form->field($model, 'ProductName')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ProductCategoryID')->dropDownList($productcategory, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ProductCategory2ID')->dropDownList($productcategory, ['prompt'=>'Select...']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ProductCategory3ID')->dropDownList($productcategory, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'UsageUnitID')->dropDownList($usageunit, ['prompt'=>'Select...']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'QtyPerUnit')->textInput(['type' => 'number']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'UnitPrice')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ReOrderLevel')->textInput(['type' => 'number']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Description')->textarea(['rows' => 6]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Active')->checkBox() ?>
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
