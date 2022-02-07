<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Organizations */
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

			<?= $form->errorSummary($model) ?>
	 
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'OrganizationName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'TradingName')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'RegistrationDate')->textInput(['type' => 'date']) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'LivelihoodActivityID')->dropDownList($livelihoodActivities, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'MaleMembers')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'FemaleMembers')->textInput(['type' => 'number']) ?>	
				</div>			
			</div>

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'PWDMembers')->textInput(['type' => 'number']) ?>
				</div>
				<div class="col-md-6">                	
                    
				</div>			
			</div> 

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'TotalAmountRequired')->textInput(['type' => 'number', 'step' => '0.1']) ?>
				</div>
				<div class="col-md-6">                	
                    <?= $form->field($model, 'CommunityContribution')->textInput(['type' => 'number', 'step' => '0.1']) ?>
				</div>			
			</div>

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'CountyContribution')->textInput(['type' => 'number', 'step' => '0.1']) ?>
				</div>
				<div class="col-md-6">                	
                    <?= $form->field($model, 'BalanceRequired')->textInput(['type' => 'number', 'step' => '0.1']) ?>
				</div>			
			</div>           

            <!--<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'PostalAddress')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'PostalCode')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>-->

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'Town')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'CountryID')->dropDownList($countries, ['prompt'=>'Select']); ?>
				</div>			
			</div>

            <!--<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'PhysicalLocation')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>-->

            <div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'Telephone')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'Mobile')->textInput(['maxlength' => true]) ?>
				</div>			
			</div>

            <!--<div class="row">
				<div class="col-md-6">
                    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
                    <?= $form->field($model, 'Url')->textInput(['maxlength' => true]) ?>	
				</div>			
			</div>-->

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt' => 'Select...', 'class' => 'form-control',
                                            'onchange' => '
                                            $.post( "' . Yii::$app->urlManager->createUrl('organizations/sub-counties?id=') . '"+$(this).val(), function( data ) {

                                                $( "select#organizations-subcountyid" ).html( data );
                                            });
                                        ']) ?>	
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'SubCountyID')->dropDownList($subCounties, ['prompt' => 'Select...', 'class' => 'form-control',
                                        'onchange' => '
                                        $.post( "' . Yii::$app->urlManager->createUrl('organizations/wards?id=') . '"+$(this).val(), function( data ) {

                                            $( "select#organizations-wardid" ).html( data );
                                        });
                                    ']) ?>
                </div>			
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'WardID')->dropDownList($wards, ['prompt' => 'Select...', 'class' => 'form-control',
                                        'onchange' => '
                                        $.post( "' . Yii::$app->urlManager->createUrl('organizations/sub-locations?id=') . '"+$(this).val(), function( data ) {

                                            $( "select#organizations-sublocationid" ).html( data );
                                        });
                                    ']) ?>	
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'SubLocationID')->dropDownList($subLocations, ['prompt'=>'Select']); ?>
                </div>			
            </div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
