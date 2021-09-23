<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$baseUrl = Yii::$app->request->baseUrl;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */
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
					<?= $form->field($model, 'ComplainantName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>
<!-- 
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'PostalAddress')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'PostalCode')->textInput() ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Town')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'CountryID')->dropDownList($countries, ['prompt' => 'Select...', 'class' => 'select2']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Mobile')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Telephone')->textInput() ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Email')->textInput() ?>
				</div>
				<div class="col-md-6">
							
				</div>			
			</div> -->

			<div class="row">
				<div class="col-md-6">
				<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt' => 'Select...', 'class' => 'select2 form-control',
					'onchange' => '
					$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {

						$( "select#complaints-subcountyid" ).html( data );
					});
				']) ?>	
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'SubCountyID')->dropDownList($subCounties, ['prompt' => 'Select...', 'class' => 'select2 form-control',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('projects/wards?id=') . '"+$(this).val(), function( data ) {

							$( "select#complaints-wardid" ).html( data );
						});
					']) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'WardID')->dropDownList($wards, ['prompt' => 'Select...', 'class' => 'select2 form-control',
						'onchange' => '
						$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-locations?id=') . '"+$(this).val(), function( data ) {
							$( "select#complaints-sublocationid" ).html( data );
						});
					']) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'SubLocationID')->dropDownList($subLocations, ['prompt'=>'Select', 'class' => 'select2']); ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ComplaintTypeID')->dropDownList($complaintTypes, ['prompt'=>'Select', 'class' => 'select2']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'IncidentDate')->textInput(['type' => 'date']) ?>	
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ComplaintSummary')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ReliefSought')->textarea(['rows' => 3]) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ComplaintTierID')->dropDownList($complaintTiers, ['prompt'=>'Select']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ComplaintChannelID')->dropDownList($complaintChannels, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt'=>'Select', 'class' => 'select2']); ?>
				</div>
				<div class="col-md-6">
					
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'OfficerJustification')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Resolution')->textarea(['rows' => 3]) ?>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'AssignedTo')->dropDownList($users, ['prompt'=>'Select', 'class' => 'select2']); ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'ComplaintPriorityID')->dropDownList($complaintPriorities, ['prompt'=>'Select']); ?>
				</div>			
			</div>

			<h4 class="form-section">Documents</h4>
			<div class="row">
				<div class="col-md-6">				
					<?= $form->field($model, 'DocumentDescription')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'imageFile')->fileInput() ?>
				</div>			
			</div>

			<?= GridView::widget([
				'dataProvider' => $documentProvider,
				'layout' => '{items}',
				'tableOptions' => [
					'class' => 'custom-table table-striped table-bordered zero-configuration',
				],
				'columns' => [
					[
						'class' => 'yii\grid\SerialColumn',
						'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
					],
					'Description',
					[
						'attribute' => 'CreatedDate',
						'format' => ['date', 'php:d/m/Y h:i a'],
						'headerOptions' => ['width' => '15%'],
					],
					[
						'label' => 'Created By',
						'attribute' => 'users.fullName',
						'headerOptions' => ['width' => '15%'],
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
						'template' => '{photo} {delete}',
						'buttons' => [
							'photo' => function($url, $model) use ($baseUrl) {								
								return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->Image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
							},
							'delete' => function ($url, $model) use ($rights) {
								return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
									'class' => 'btn-sm btn-danger btn-xs',
									'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('documents/delete?id=' . $model->DocumentID) . '", \'tab15\')',
								]) : '';
							},
						],
					],
				],
			]); ?>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>

<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script src="<?= $baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>
