<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */
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
			<?php $form = ActiveForm::begin([
			        'action' => 'import',
                    'id' => 'excel-doc-upload',
                    'enableClientValidation' => true,
                    'encodeErrorSummary' => false,
                    'options' => [
			            'enctype' => 'multipart/form-data'
            ]]);

             $form->errorSummary($model) ;

			?>
	 
	 		<div class="row">
				<div class="col-md-8">
				<?= $form->field($model, 'excel_doc')->fileInput() ?>
				</div>

			</div>


            <div class="form-group">

                <?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
            </div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
