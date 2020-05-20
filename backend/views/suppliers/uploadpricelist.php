<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Price List';
$baseUrl = Yii::$app->request->baseUrl;
?>
<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
					
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
						<p>
						<div id="msg" style="color:red"></div></p>
						<?php $form = ActiveForm::begin([
						'id' => 'upload-form',
								'fieldConfig' => [
								'options' => ['tag' => false],
								'enableClientValidation'=> false,
								'enableAjaxValidation'=> true,
							],
						]); 
						?>
						<?= $form->field($model, 'myFile')->fileInput() ?>
						<p></p>
						<div class="help-block-error"><?= $message; ?></div>
						<p></p>
						<div class="form-group">
							<?= Html::a('<i class="ft-x"></i> Close', ['update', 'id' => $id], ['class' => 'btn btn-warning mr-1']) ?>
							<?= Html::submitButton('<i class="ft-upload"></i> Upload', ['class' => 'btn btn-primary']) ?>
						</div>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
