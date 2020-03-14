<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\projects */
$baseUrl = Yii::$app->request->baseUrl;
$this->title = $model->ProjectName;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$activityID = 0;
\yii\web\YiiAsset::register($this);

Modal::begin([
	'header' => '<h4 class="modal-title">Activity Budget</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'activity-budget',
	'size' => 'modal-xl',
	]);

Modal::end();

Modal::begin([
	'header' => '<h4 class="modal-title">Actuals</h4>',
	'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'actuals',
	'size' => 'modal-xl',
	]);

Modal::end();
?>
<style>

.modal-header .close {
  /* display:none; */
  color: black !important;
}

</style>

<style>
#ParameterTable .form-group {
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	/* padding: 4px !important; */
}
</style>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$("#activity-budget").on("show.bs.modal", function(e) {
			var id = $(e.relatedTarget).data('activity-id')
			$.get( "<?= $baseUrl; ?>/indicators/activity-budget?id=" + id, function( data ) {
					$(".modal-body").html(data);
			});
		});

		$("#budget").on('beforeSubmit', function (event) { 
			event.preventDefault();            
			var form_data = new FormData($('#form-add-contact')[0]);
			$.ajax({
					url: $("#form-add-contact").attr('action'), 
					dataType: 'JSON',  
					cache: false,
					contentType: false,
					processData: false,
					data: form_data, //$(this).serialize(),                      
					type: 'post',                        
					beforeSend: function() {
					},
					success: function(response){                      
						toastr.success("",response.message); 
						$('#addContactFormModel').modal('hide');
					},
					complete: function() {
					},
					error: function (data) {
						toastr.warning("","There may a error on uploading. Try again later");    
					}
				});                
				return false;
		});

		
	});

	function submitForm(id) {
		$.ajax({
			type: "POST",
			url: $("#budget").attr('action'),
			data: $("#budget").serialize(),
			success: function( response ) {
				$("#activity-budget").modal('toggle');
			}
		});
	}

	function closeModal() {
		$("#activity-budget").modal('hide');
	}

/* 	$('#activity-budget').on('hidden.bs.modal', function (e) {
	// do something...
	}) */

	// Acutals
	$("#actuals").on("show.bs.modal", function(e) {
			var id = $(e.relatedTarget).data('activity-id')
			$.get( "<?= $baseUrl; ?>/indicators/activity-budget?id=" + id, function( data ) {
					$(".modal-body").html(data);
			});
		});
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
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index', 'cid' => $model->ComponentID], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->ProjectID], ['class' => 'btn btn-primary']) : ''?>
							<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ProjectID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) : ''?>				
						</p>					

						<div class="card">
							<!-- <div class="card-header">
								<h4 class="card-title">Top Border Tabs</h4>
							</div> -->
							<div class="card-content">
								<div class="card-body">
									<!-- <p>Use <code>.nav-top-border.no-hover-bg</code> class for top bordered active type. </p> -->
									<ul class="nav nav-tabs nav-top-border no-hover-bg">
										<li class="nav-item">
											<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Details</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Finance Sources</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Risk</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Disbursement</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Safeguards</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab16" href="#tab6" aria-expanded="false">Beneficiaries</a>
										</li>															
										<li class="nav-item">
											<a class="nav-link" id="base-tab7" data-toggle="tab" aria-controls="tab7" href="#tab7" aria-expanded="false">Project Team</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab8" data-toggle="tab" aria-controls="tab8" href="#tab8" aria-expanded="false">Indicators</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab9" data-toggle="tab" aria-controls="tab9" href="#tab9" aria-expanded="false">Targets</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab10" data-toggle="tab" aria-controls="tab10" href="#tab10" aria-expanded="false">Actual</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab11" data-toggle="tab" aria-controls="tab11" href="#tab11" aria-expanded="false">Budget</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab12" href="#tab12" aria-expanded="false">Reporting Periods</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab13" href="#tab13" aria-expanded="false">Notes</a>
										</li>	
										<li class="nav-item">
											<a class="nav-link" id="base-tab14" data-toggle="tab" aria-controls="tab14" href="#tab14" aria-expanded="false">Gallery</a>
										</li>		
										<li class="nav-item">
											<a class="nav-link" id="base-tab15" data-toggle="tab" aria-controls="tab15" href="#tab15" aria-expanded="false">Documents</a>
										</li>		
										<li class="nav-item">
											<a class="nav-link" id="base-tab16" data-toggle="tab" aria-controls="tab16" href="#tab16" aria-expanded="false">Complaints</a>
										</li>		
										<li class="nav-item">
											<a class="nav-link" id="base-tab17" data-toggle="tab" aria-controls="tab17" href="#tab17" aria-expanded="false">GBV/SEA</a>
										</li>					
									</ul>
									<div class="tab-content px-1 pt-1">
										<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
											<h4 class="form-section">Details</h4>	
											<?= DetailView::widget([
											'model' => $model,
											'attributes' => [
													'ProjectID',
													'ProjectName',
													[
														'label' => 'Parent Project',
														'attribute' => 'parentProject.ProjectName',
													],
													'components.ComponentName',
													'Objective:ntext',
													'Justification:ntext',
													[
														'attribute' => 'ApprovalDate',
														'format' => ['date', 'php:d/m/Y'],
													],
													[
														'attribute' => 'StartDate',
														'format' => ['date', 'php:d/m/Y'],
													],
													[
														'attribute' => 'EndDate',
														'format' => ['date', 'php:d/m/Y'],
													],
													[
														'attribute' => 'ProjectCost',
														'format' => ['decimal', 2],
													],
													'currencies.CurrencyName',
													'counties.CountyName',
													'subCounties.SubCountyName',
													'locations.LocationName',
													'subLocations.SubLocationName',
													'communities.CommunityName',
													'Longitude',
													'Latitude',
													[
														'attribute' => 'projectStatus.ProjectStatusName',
														'label' => 'Status',
														'headerOptions' => ['width' => '10%'],
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
											
										</div>
										<div class="tab-pane" id="tab2" aria-labelledby="base-tab12">
											<h4 class="form-section">Finance Sources</h4>	 
											<?= GridView::widget([
												'dataProvider' => $projectFunding,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													/* [
														'attribute' => 'ProjectFundingID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													], */
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Funding Source',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'fundingSources.FundingSourceName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Amount',
														'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:right'],
														'format'=> ['Decimal',2],
														'value' => 'Amount',														
														'contentOptions' => ['style' => 'text-align:right'],
													],
												],
											]); ?>
										</div>
										<div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
											<h4 class="form-section">Risk</h4>									
											<?= GridView::widget([
												'dataProvider' => $projectRisk,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													/* [
														'attribute' => 'ProjectRiskID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													], */
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Risk',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'ProjectRiskName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Risk Rating',
														'headerOptions' => [ 'width' => '20%', 'style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'riskRating.RiskRatingName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Risk Likelihood',
														'headerOptions' => [ 'width' => '20%', 'style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'riskLikelihood.RiskLikelihoodName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
												],
											]); ?>
										
										</div>
										<div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
											<h4 class="form-section">Disbursement</h4>		 
											<?= GridView::widget([
												'dataProvider' => $projectDisbursement,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Year',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'Year',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Date',
														'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
														'format' => ['date', 'php:d/m/Y'],
														'value' => 'Date',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Amount',
														'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:right'],
														'format'=> ['Decimal',2],
														'value' => 'Amount',
														'contentOptions' => ['style' => 'text-align:right'],
													],
												],
											]); ?>
										</div>
										<div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
											<h4 class="form-section">Safeguards</h4>
											<div id="safeguards">											
												<?= $this->render('safeguards', ['projectSafeguards' => $projectSafeguards, 'model' => $model]); ?>
											</div>
										</div>
										<div class="tab-pane" id="tab6" aria-labelledby="base-tab6">
											<h4 class="form-section">Beneficiaries</h4>	 
											<?= GridView::widget([
												'dataProvider' => $projectBeneficiaries,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													/* [
														'attribute' => 'ProjectBeneficiaryID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													], */
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'County',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'counties.CountyName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Sub County',
														'headerOptions' => ['width' => '30%', 'style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'subCounties.SubCountyName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Host Population',
														'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:right'],
														'format'=> ['decimal', 2],
														'value' => 'HostPopulation',
														'contentOptions' => ['style' => 'text-align:right'],
													],
													[
														'label'=>'Refugee Population',
														'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:right'],
														'format'=> ['decimal', 2],
														'value' => 'RefugeePopulation',
														'contentOptions' => ['style' => 'text-align:right'],
													],
												],
											]); ?>
										</div>
										<div class="tab-pane" id="tab7" aria-labelledby="base-tab7">
											<h4 class="form-section">Project Team</h4>	 
											<?= GridView::widget([
												'dataProvider' => $projectTeams,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													/* [
														'attribute' => 'ProjectTeamID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													], */
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Team Member',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'ProjectTeamName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Role',
														'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'projectRoles.ProjectRoleName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Specialization',
														'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'Specialization',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'label'=>'Unit',
														'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'projectUnits.ProjectUnitName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
												],
											]); ?>
										</div>
										<div class="tab-pane" id="tab8" aria-labelledby="base-tab8">
											<h4 class="form-section">Indicators</h4>
											<div class="form-actions" style="margin-top:0px">
												<?= Html::a('<i class="ft-plus"></i> New Indicator', ['/indicators/create', 'pid' => $model->ProjectID], ['class' => 'btn-sm btn-primary mr-1']) ?>	 
											</div>
											<table class="custom-table table-striped table-bordered"><thead>
											<tr>
												<th width="5%" style="color:black; text-align:center">ID</th>
												<th style="color:black; text-align:left">Indicator</th>
												<th width="15%">Unit Of Measure</th>
												<th width="10%" style="text-align:right">Base Line</th>
												<th width="10%" style="text-align:right">End Target</th>
												<th width="20%" style="color:black; text-align:center">&nbsp;</th>
											</tr>
											</thead>
											<tbody>											
											<?php 
											foreach ($indicators->models as $key => $indicator) { ?>
												<tr data-key="2">
													<td style="text-align:center"><?= $key + 1; ?></td>
													<td style="text-align:left"><?= $indicator->IndicatorName; ?></td>
													<td><?= $indicator->unitsOfMeasure->UnitOfMeasureName; ?></td>
													<td style="text-align:right"><?= number_format($indicator->BaseLine,2); ?></td>
													<td style="text-align:right"><?= number_format($indicator->EndTarget,2 ); ?></td>
													<td style="text-align:right">
														<?= Html::a('<i class="ft-edit"></i> Update', ['indicators/update', 'id' => $indicator->IndicatorID, 'pid' => $indicator->ProjectID], ['class' => 'btn-sm btn-primary']) ?>
														<?= Html::a('<i class="ft-trash"></i> Delete', ['indicators/delete', 'id' => $indicator->IndicatorID, 'pid' => $indicator->ProjectID], [
																'class' => 'btn-sm btn-danger',
																'data' => [
																	'confirm' => 'Are you sure you want to delete this item?',
																	'method' => 'post',
																],
														]) ?>
													</td>
												</tr>	
												<tr data-key="2">
													<td colspan="7">
														<h5>Activities</h5>
														<table class="custom-table table-striped table-bordered">
														<thead>
														<tr>
															<th width="5%" style="color:black; text-align:center">ID</th>
															<th style="color:black; text-align:left">Activity</th>
															<th width="10%">Start Date</th>
															<th width="10%">End Date</th>
															<th width="10%">Responsibility</th>
															<td width="10%">Actual Start Date</td>
															<td width="10%">Actual End Date</td>
															<td width="10%" style="text-align:right">Total</td>
															<th width="5%" style="color:black; text-align:center">&nbsp;</th>
														</tr>
														</thead>
														<tbody>
															<?php
															$activitiesList = isset($activities[$indicator->IndicatorID]) ? $activities[$indicator->IndicatorID] : [];
															$grandTotal = 0;
															foreach ($activitiesList as $akey => $activity) { 
																$total = isset($activityTotals[$activity->ActivityID]) ? $activityTotals[$activity->ActivityID]['Total'] : 0;
																$grandTotal += $total;
																?>
																<tr data-key="2">
																	<td style="text-align:center"><?= $akey + 1?></td>
																	<td style="text-align:left"><?= $activity->ActivityName; ?></td>
																	<td><?= isset($activity->StartDate)? date('d/m/Y', strtotime($activity->StartDate)) : ''; ?></td>
																	<td><?= isset($activity->EndDate)? date('d/m/Y', strtotime($activity->EndDate))  : ''; ?></td>
																	<td><?= isset($activity->employees) ? $activity->employees->EmployeeName : ''; ?></td>
																	<td><?= isset($activity->ActualStartDate)? date('d/m/Y', strtotime($activity->ActualStartDate))  : ''; ?></td>
																	<td><?= isset($activity->ActualEndDate)? date('d/m/Y', strtotime($activity->ActualEndDate)) : ''; ?></td>	
																	<td style="text-align:right"><?= number_format($total, 2); ?></td>															
																	<td><a href="#activity-budget" class = "btn-sm btn-danger pull-right" data-toggle="modal" data-activity-id="<?= $activity->ActivityID; ?>"><i class="ft-more-horizontal"></i></a>
																		<!-- <a class="btn-sm btn-secondary" href="/mande/backend/web/indicators/update?id=2&amp;pid=1"><i class="ft-more-horizontal"></i></a> -->
																	</td>
																</tr>	
																<?php
															} ?>
															</tbody>
															<tfoot>
															<tr>
																<th width="5%" style="color:black; text-align:center">&nbsp;</th>
																<th colspan="6">Total</th>
																<td width="10%" style="text-align:right"><?= number_format($grandTotal,2); ?></td>
																<th width="5%">&nbsp;</th>
															</tr>
															</tfoot>
														</table>
													</td>
												</tr>
												
												<?php
											} ?>
											</tbody></table>
											<?php /*  GridView::widget([
												'dataProvider' => $indicators,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'attribute' => 'IndicatorID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													],
													[
														'label'=>'Indicator',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'IndicatorName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													'unitsOfMeasure.UnitOfMeasureName',
													'BaseLine',
													'EndTarget',
													'subComponents.SubComponentName',
													[
														'class' => 'yii\grid\ActionColumn',
														'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
														'template' => '{view}',
														'buttons' => [
									
															'view' => function ($url, $model) {
																return (Html::a('<i class="ft-eye"></i> Update', ['indicators/update', 'id' => $model->IndicatorID, 'pid' => $model->ProjectID], ['class' => 'btn-sm btn-primary']));
															},															
														],
													],
												],
											]); */ ?>
										</div>

										<div class="tab-pane" id="tab9" aria-labelledby="base-tab9">
											<h4 class="form-section">Targets</h4>
											<table class="custom-table table-striped table-bordered"><thead>
											<tr>
												<th width="5%" style="color:black; text-align:center">ID</th>
												<th style="color:black; text-align:left">Indicator</th>
												<th>Unit Of Measure</th>
												<th>Base Line</th>
												<th>End Target</th>
												<?php
												foreach ($reportingPeriods->models as $key => $period) { ?>
													<td><?= $period->ReportingPeriodName ;?></td>
												<?php } ?>
											</tr>
											</thead>
												<tbody>
												<?php
												foreach ($indicators->models as $key => $indicator) {
													?>
													<tr>
														<td style="text-align:center"><?= $key + 1; ?></td>
														<td style="text-align:left"><?= $indicator['IndicatorName']; ?></td>
														<td><?= $indicator['unitsOfMeasure']['UnitOfMeasureName']; ?></td>
														<td align="right"><?= number_format($indicator['BaseLine'],2); ?></td>
														<td align="right"><?= number_format($indicator['EndTarget'],2); ?></td>
														<?php
														foreach ($reportingPeriods->models as $key => $period) { ?>
														 	<td align="right"><?= isset($targets[$indicator->IndicatorID][$period->ReportingPeriodID]) ? $targets[$indicator->IndicatorID][$period->ReportingPeriodID]['Target'] : ''; ?></td>
														<?php } ?>
													</tr>
													<?php
												} ?>
												</tbody>
											</table>
										</div>

										<div class="tab-pane" id="tab10" aria-labelledby="base-tab10">
											<form method="post">
											<h4 class="form-section">Actual</h4>
											<table class="custom-table table-striped table-bordered"><thead>
											<tr>
												<th width="5%" style="color:black; text-align:center">ID</th>
												<th style="color:black; text-align:left">Indicator</th>
												<th>Unit Of Measure</th>
												<th>Base Line</th>
												<th>End Target</th>
												<?php
												foreach ($reportingPeriods->models as $key => $period) { ?>
													<td width="15%"><?= $period->ReportingPeriodName ;?></td>
												<?php } ?>
											</tr>
											</thead>
												<tbody>
												<?php
												foreach ($indicators->models as $key => $indicator) {
													?>
													<tr>
														<td style="text-align:center"><?= $key + 1; ?></td>
														<td style="text-align:left"><?= $indicator['IndicatorName']; ?></td>
														<td><?= $indicator['unitsOfMeasure']['UnitOfMeasureName']; ?></td>
														<td align="right"><?= number_format($indicator['BaseLine'], 2); ?></td>
														<td align="right"><?= number_format($indicator['EndTarget'],2); ?></td>
														<?php
														foreach ($reportingPeriods->models as $key => $period) {
															$value = isset($actuals[$indicator->IndicatorID][$period->ReportingPeriodID]) ? $actuals[$indicator->IndicatorID][$period->ReportingPeriodID]['Actual'] : '';
															$name = $indicator->IndicatorID.'_'.$period->ReportingPeriodID;
															?>
															<td align="right">
																<input name="<?= $name; ?>" type="text" value="<?= $value; ?>" style="width:100%">	
															</td>
														<?php } ?>
													</tr>
													<?php
												} ?>
												</tbody>
											</table>
											<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
											</form>
										</div>

										<div class="tab-pane" id="tab11" aria-labelledby="base-tab11">
											<!-- <h4 class="form-section">Budget</h4> -->
											<?= $this->render('/activity-budget/index', ['id' => $model->ProjectID, 'budgetProvider' => $budgetProvider]);  ?>
										</div>

										<div class="tab-pane" id="tab12" aria-labelledby="base-tab12">
											<h4 class="form-section">Reporting Periods</h4>	 
											<?= GridView::widget([
												'dataProvider' => $reportingPeriods,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													/* [
														'attribute' => 'ReportingPeriodID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													], */
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Period',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'ReportingPeriodName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'attribute' => 'ExpectedDate',
														'format' => ['date', 'php:d/m/Y'],
														'headerOptions' => ['width' => '15%'],
													],
													[
														'attribute' => 'CreatedDate',
														'format' => ['date', 'php:d/m/Y h:i a'],
														'headerOptions' => ['width' => '17%'],
													],
													[
														'label' => 'Created By',
														'attribute' => 'users.fullName',
														'headerOptions' => ['width' => '15%'],
													],
												],
											]); ?>
										</div>

										<div class="tab-pane" id="tab13" aria-labelledby="base-tab13">
											<h4 class="form-section">Notes</h4>	 
											<?= GridView::widget([
												'dataProvider' => $projectNotes,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													/* [
														'attribute' => 'ProjectNoteID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													], */
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Notes',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'Notes',
														'contentOptions' => ['style' => 'text-align:left'],
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
										</div>

										<div class="tab-pane" id="tab14" aria-labelledby="base-tab14">
											<h4 class="form-section">Gallery</h4>	
											<div class="form-actions" style="margin-top:0px">
												<?= Html::a('<i class="ft-plus"></i> New Image', ['/project-gallery/create', 'pid' => $model->ProjectID], ['class' => 'btn-sm btn-primary mr-1']) ?>	 
											</div> 
											<?= GridView::widget([
												'dataProvider' => $projectGallery,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[

														'attribute' => 'Image',										
														'format' => ['image',['height'=>'50']],										
														'label' => 'Image',							
																							
												  	],
													[
														'label'=>'Caption',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'Caption',
														'contentOptions' => ['style' => 'text-align:left'],
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
										</div>

										<div class="tab-pane" id="tab15" aria-labelledby="base-tab15">
											<h4 class="form-section">Documents</h4>	
											<div class="form-actions" style="margin-top:0px">
												<?= Html::a('<i class="ft-plus"></i> New Document', ['/projects/documents', 'pid' => $model->ProjectID], ['class' => 'btn-sm btn-primary mr-1']) ?>	 
											</div> 
											<?= GridView::widget([
												'dataProvider' => $projectDocuments,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													/* [

														'attribute' => 'Image',										
														'format' => ['image',['height'=>'50']],										
														'label' => 'Image',							
																							
												  	], */
													[
														'label'=>'Description',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'Description',
														'contentOptions' => ['style' => 'text-align:left'],
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
													[
														'class' => 'yii\grid\ActionColumn',
														'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
														'template' => '{view}',
														'buttons' => [
					
															'view' => function ($url, $model) use ($rights) {
																return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view-document', 'id' => $model->DocumentID], ['class' => 'btn-sm btn-primary']) : '';
															},
														],
													],
												],
											]); ?>
										</div>

										<div class="tab-pane" id="tab16" aria-labelledby="base-tab16">
											<h4 class="form-section">Complaints</h4>	
											 
											<?= GridView::widget([
												'dataProvider' => $complaints,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'class' => 'yii\grid\SerialColumn',
														'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
													],
													[
														'label'=>'Complainant',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'ComplainantName',
														'contentOptions' => ['style' => 'text-align:left'],
													],
													[
														'attribute' => 'complaintTypes.ComplaintTypeName',
														'format' => 'text',
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
													[
														'attribute' => 'complaintStatus.ComplaintStatusName',
														'format' => 'text',
														'headerOptions' => ['width' => '15%'],
														'label' => 'Status'
													],
												],
											]); ?>
										</div>

										<div class="tab-pane" id="tab17" aria-labelledby="base-tab17">
											<?php $form = ActiveForm::begin(); ?>		
												<h4 class="form-section">GBV/SEA</h4>
												<table class="custom-table table-striped table-bordered" id="ParameterTable" >
												<thead>
												<tr>
													<th width="5%" style="color:black; text-align:center">ID</th>
													<th style="color:black; text-align:left">Question</th>
													<th width="20%" >Option</th>
												</tr>
												</thead>
													<tbody>
													<?php
													$catID = 0;
													$subCatID = 0;
													foreach ($projectQuestionnaire as $x => $question) {
														if ($catID != $question['QuestionnaireCategoryID']) { ?>
															<tr>
																<td style="padding: 4px 4px 4px 4px !important" colspan="3"><?= $question['QuestionnaireCategoryName']; ?></td>
															</tr>
															<?php
															$catID = $question['QuestionnaireCategoryID'];
															$subCatID = 0;
														}
														if ($subCatID != $question['QuestionnaireSubCategoryID']) { ?>
															<tr>
																<td style="padding: 4px 4px 4px 4px !important" colspan="3"><?= $question['QuestionnaireSubCategoryName']; ?></td>
															</tr>
															<?php
															$subCatID = $question['QuestionnaireSubCategoryID'];
														}
														?>
														<tr>
															<td align="center" style="padding: 4px 4px 4px 4px !important">
																<?= $x + 1; ?>
																<?= $form->field($question, '[' . $x . ']ProjectQuestionnaireID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
																<?= $form->field($question, '[' . $x . ']QID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
															</td>
															<td style="padding: 4px 4px 4px 4px !important"><?= $question['Question']; ?></td>
															<td align="center" style="padding: 4px 4px 4px 4px !important"><?= $form->field($question, '[' . $x . ']QuestionnaireStatusID', ['template' => '{label}{input}'])->dropDownList($questionnaireStatus, ['prompt'=>'','class'=>'form-control', 'style' => 'border-bottom: none'])->label(false) ?></td>
														</tr>
														<?php
													} ?>
													</tbody>
												</table>
												<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
											<?php ActiveForm::end(); ?>
										</div>

									</div>
								</div>
							</div>
						</div>										
											
					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
