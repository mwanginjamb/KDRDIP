<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	$this->params['breadcrumbs'][] = $this->title;
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
						<?php 
							$form = ActiveForm::begin([
							'id' => 'contact-form',
								'fieldConfig' => [
									'options' => ['tag' => false, ],
									'enableClientValidation'=> false,
									'enableAjaxValidation'=> false,
								],
							]);
							
							?>
							<div class="row">
								<div class="col-lg-4">
									<?= $form->field($model, 'SupplierID')->dropDownList($suppliers, ['prompt'=>'All...']); ?>
								</div>				
								<div class="col-lg-4">
									<div class="form-group" style="padding-top:15px">
										<?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group" style="padding-top:15px">
										<?= Html::a('Close', ['view', 'id' => $quotation->QuotationID], ['class' => 'btn btn-warning place-right', 'style' => 'margin-bottom:10px']) ?>
									</div>
								</div>
							</div>	
							<?php ActiveForm::end(); ?>		
						<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>