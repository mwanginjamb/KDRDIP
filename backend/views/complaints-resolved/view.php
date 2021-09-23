<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Complaints */

$this->title = 'Resolved Complaints: ' .$model->ComplainantName;
$this->params['breadcrumbs'][] = ['label' => 'Complaints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

Modal::begin([
	'header' => '<h4 class="modal-title">Document</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'pdf-viewer',
	'size' => 'modal-lg',
	]);

Modal::end();
?>
<style>
	#ParameterTable .form-group {
		margin-bottom: 0px !important;
		margin-top: 0px !important;
		/* padding: 4px !important; */
	}
	.modal-header {
		display: block !important;
	}
</style>

<script>
window.onload = cancel;

function reAssign() {
	var x = document.getElementById("activity");
	x.style.display = "block";
	document.getElementById("assignTo").style.display = "block";
	document.getElementById("complaintStatus").style.display = "none";
	document.getElementById("assignedform-activityid").value = 2;
}

function addComments() {
	var x = document.getElementById("activity");
	x.style.display = "block";
	document.getElementById("assignTo").style.display = "none";
	document.getElementById("complaintStatus").style.display = "none";
	document.getElementById("assignedform-activityid").value = 1;
}

function changeStatus() {
	var x = document.getElementById("activity");
	x.style.display = "block";
	document.getElementById("assignTo").style.display = "none";
	document.getElementById("complaintStatus").style.display = "block";
	document.getElementById("assignedform-activityid").value = 3;
}

function cancel() {
	var x = document.getElementById("activity");
	x.style.display = "none";
	document.getElementById("activityId").style.display = "none";
}
</script>

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
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->Edit) && $rights->Edit) ? Html::a('<i class="ft-file-text"></i> Add Comments', null, ['class' => 'btn btn-primary mr-1', 'style' => 'color: white', 'onclick' => 'addComments()']) : '' ?>
							<?php // (isset($rights->Edit) && $rights->Edit) ? Html::a('<i class="ft-user"></i> Re-Assign', null, ['class' => 'btn btn-primary mr-1', 'style' => 'color: white', 'onclick' => 'reAssign()']) : '' ?>
							<?= (isset($rights->Edit) && $rights->Edit) ? Html::a('<i class="ft-chevron-right"></i> Change Status', null, ['class' => 'btn btn-primary mr-1', 'style' => 'color: white', 'onclick' => 'changeStatus()']) : '' ?>
						</p>

						<div id="activity">
							<h4 class="form-section">Activity</h4>
							<?php $form = ActiveForm::begin(); ?>
												
								<div class="row">
									<div class="col-md-6">
										<?= $form->field($assignedForm, 'comments')->textarea(['rows' => 3]) ?>								
									</div>		
								</div>
												
								<div class="row" id="activityId">
									<div class="col-md-6">
										<?= $form->field($assignedForm, 'activityId')->textInput(['maxlength' => true]) ?>									
									</div>		
								</div>

								<div class="row" id="assignTo">
									<div class="col-md-6">
										<?= $form->field($assignedForm, 'assignedTo')->dropDownList($users, ['class' => 'select2']); ?>
									</div>			
								</div>

								<div class="row" id="complaintStatus">
									<div class="col-md-6">
										<?= $form->field($assignedForm, 'complaintStatusId')->dropDownList($complaintStatus); ?>
									</div>			
								</div>							

								<div class="form-group">
									<?= Html::a('<i class="ft-x"></i> Cancel', null, ['class' => 'btn btn-danger mr-1', 'style' => 'color: white', 'onclick' => 'cancel()']) ?>
									<?= (isset($rights->Edit) && $rights->Edit) ? Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) : '' ?>
								</div>

							<?php ActiveForm::end(); ?>
						</div>

						<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
								'ComplaintID',
								'ComplainantName',
								'countries.CountryName',
								'counties.CountyName',
								'subCounties.SubCountyName',
								'wards.WardName',
								[
									'attribute' => 'subLocations.SubLocationName',
									'label' => 'Village'
								],
								'complaintTypes.ComplaintTypeName',
								[
									'attribute' => 'IncidentDate',
									'format' => ['date', 'php:d/m/Y'],
								],
								'projects.ProjectName',
								'ComplaintSummary:ntext',
								'ReliefSought:ntext',
								'OfficerJustification:ntext',
								'complaintTiers.ComplaintTierName',
								'complaintChannels.ComplaintChannelName',
								'complaintPriorities.ComplaintPriorityName',
								'complaintStatus.ComplaintStatusName',
								[
									'attribute' => 'assignedUser.FullName',
									'label' => 'Assigned User',
								],
								'Resolution:ntext',
								[
									'attribute' => 'ClosedDate',
									'format' => ['date', 'php:d/m/Y'],
								],
								[
									'attribute' => 'CreatedDate',
									'format' => ['date', 'php:d/m/Y h:i a'],
								],
								[
									'label' => 'Created By',
									'attribute' => 'users.fullName',
								],
							],
						]) ?>
						<h4 class="form-section">Notes</h4>
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
								'Notes',
								[
									'attribute' => 'complaintStatus.ComplaintStatusName',
									'headerOptions' => ['width' => '15%'],
								],
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
							],
						]); ?>

						<h4 class="form-section">Documents</h4>
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
									'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
									'template' => '{photo}',
									'buttons' => [
										'photo' => function($url, $model) use ($baseUrl) {								
											return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->Image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
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
<script>
	$(document).ready(function() {

		$("#pdf-viewer").on("show.bs.modal", function(e) {
			var image = $(e.relatedTarget).data('image');
			var title = $(e.relatedTarget).data('title');
			$(".modal-body").html('<iframe src="'+  image +'" height="700px" width="100%"></iframe>');
			$(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">' + title + '</h4>');
		});
	});
</script>
<script src="<?= $baseUrl; ?>/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script> $(".select2").select2(); </script>
