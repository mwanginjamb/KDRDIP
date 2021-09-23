<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assigned Complaints';
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
					<div class="card-body card-dashboard">

						<?php $form = ActiveForm::begin(); ?>
							<div class="row">
								<div class="col-md-2">
									<?= $form->field($filter, 'ComponentID')->dropDownList($components, ['prompt' => 'All', 'class' => 'select2 form-control',
														'onchange' => '
														$.post( "' . Yii::$app->urlManager->createUrl('components/projects?id=') . '"+$(this).val(), function( data ) {

															$( "select#complaintsfilter-projectid" ).html( data );
														});
													']); ?>
								</div>
								<div class="col-md-2">
									<?= $form->field($filter, 'ProjectID')->dropDownList($projects, ['prompt'=>'All', 'class' => 'select2']); ?>
								</div>
								<div class="col-md-2">
									<?= $form->field($filter, 'StartDate')->textInput(['maxlength' => true, 'type' => 'date']) ?>
								</div>
								<div class="col-md-2">
									<?= $form->field($filter, 'EndDate')->textInput(['maxlength' => true, 'type' => 'date']) ?>
								</div>
								<div class="col-md-2">
									<?= $form->field($filter, 'ComplaintStatusID')->dropDownList($complaintStatus, ['prompt' => 'All', 'class' => 'select2']); ?>
								</div>
								<div class="col-md-2">
									<?= $form->field($filter, 'ComplaintTypeID')->dropDownList($complaintTypes, ['prompt' => 'All', 'class' => 'select2']); ?>
								</div>		
							</div>

							<div class="row">
								<div class="col-md-3">
								<?= $form->field($filter, 'CountyID')->dropDownList($counties, ['prompt' => 'All', 'class' => 'select2 form-control',
														'onchange' => '
														$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {

															$( "select#complaintsfilter-subcountyid" ).html( data );
														});
													']) ?>	
								</div>
								<div class="col-md-3">
									<?= $form->field($filter, 'SubCountyID')->dropDownList($subCounties, ['prompt' => 'All', 'class' => 'select2 form-control',
														'onchange' => '
														$.post( "' . Yii::$app->urlManager->createUrl('projects/wards?id=') . '"+$(this).val(), function( data ) {

															$( "select#complaintsfilter-wardid" ).html( data );
														});
													']) ?>
								</div>
								<div class="col-md-3">
									<?= $form->field($filter, 'WardID')->dropDownList($wards, ['prompt' => 'All', 'class' => 'select2 form-control',
														'onchange' => '
														$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-locations?id=') . '"+$(this).val(), function( data ) {
															$( "select#complaintsfilter-sublocationid" ).html( data );
														});
													']) ?>
								</div>
								<div class="col-md-3">
									<?= Html::submitButton('<i class="ft-search"></i> Filter', ['class' => 'btn btn-primary', 'style' => 'margin-top: 25px;']) ?>
								</div>
							</div>	

							<div class="row" style="margin-bottom:10px">
								<div class="col-md-4">
									<?= (isset($rights->Create) && $rights->Create) ? Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) : '' ?>	
								</div>
								<div class="col-md-8" style="text-align: right;">
									<?= Html::submitButton('<i class="ft-printer"></i> Print', ['name' => 'print', 'class' => 'btn btn-primary mr-1']); ?>	
									<?= Html::submitButton('<i class="ft-download-cloud"></i> Download', ['name' => 'download', 'class' => 'btn btn-primary']); ?>	
								</div>
							</div>

						<?php ActiveForm::end(); ?>
						
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								'ComplainantName',
								[
									'attribute' => 'complaintTypes.ComplaintTypeName',
									'format' => 'text',
									'headerOptions' => ['width' => '15%'],
									'label' => 'Complaint Type'
								],
								[
									'attribute' => 'complaintStatus.ComplaintStatusName',
									'headerOptions' => ['width' => '15%'],
									'label' => 'Status',
								],
								[
									'attribute' => 'CreatedDate',
									'format' => ['date', 'php:d/m/Y h:i a'],
									'headerOptions' => ['width' => '15%'],
								],
								[
									'label' => 'Age (Days)',
									'attribute' => 'complaintAge',
									'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
									'contentOptions' => ['style'=>'color:black; text-align:center'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
									'template' => '{view}',
									'buttons' => [

										'view' => function ($url, $model) use ($rights) {
											return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->ComplaintID], ['class' => 'btn-sm btn-primary']) : '';
										},
									],
								],
							],
						]); ?>

					</div>
				</div>										  
			</div>
		</div>
	</div>
</section>

<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script src="<?= $baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>
