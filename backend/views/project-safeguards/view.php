<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\grid\GridView;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityGroups */

$this->title = $model->ProjectName;
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' => ['index']];
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
						</p>

						<div class="card">
							<div class="card-content">
								<div class="card-body">

									<ul class="nav nav-tabs nav-top-border no-hover-bg">
										<li class="nav-item">
											<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Details</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('safeguards-documents/index?pId=' . $model->ProjectID);?>', 'tab2')">Documentation</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('project-beneficiaries/index?pId=' . $model->ProjectID);?>', 'tab6')">Beneficiaries</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('safeguard-question-responses/index?tab=tab4&categoryId=2&pId=' . $model->ProjectID);?>', 'tab4')">Stakeholder Consultation and Inclusion</a>
										</li>	
										<li class="nav-item">
											<a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Grievance Management</a>
										</li>	
										<li class="nav-item">
											<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('safeguard-question-responses/index?tab=tab3&categoryId=3&pId=' . $model->ProjectID);?>', 'tab3')">Land Acquisition</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab19" data-toggle="tab" aria-controls="tab19" href="#tab19" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('project-challenges/index?pId=' . $model->ProjectID . '&typeId=1');?>', 'tab19')">Security Issues</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab8" data-toggle="tab" aria-controls="tab8" href="#tab8" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('safeguard-question-responses/index?tab=tab8&categoryId=4&pId=' . $model->ProjectID);?>', 'tab8')">E&S Impacts</a>
										</li>		
																				
									</ul>
									<div class="tab-content px-1 pt-1">
										<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
											<h4 class="form-section">Details</h4>						

												<?= DetailView::widget([
												'model' => $model,
												'options' => [
													'class' => 'custom-table table-striped table-bordered zero-configuration',
												],
												'attributes' => [
														'ProjectID',
														'ProjectName',
														/* [
															'label' => 'Parent Project',
															'attribute' => 'parentProject.ProjectName',
														], */
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
														'wards.WardName',
														/* [
															'attribute' => 'locations.LocationName',
															'label' => 'Ward',
														], */
														[
															'attribute' => 'subLocations.SubLocationName',
															'label' => 'Village',
														],
														'communities.CommunityName',
														'Longitude',
														'Latitude',
														'enterpriseTypes.EnterpriseTypeName',
														'organizationName',
														'projectSectors.ProjectSectorName',
														'projectSectorInterventions.SectorInterventionName',
														'subComponents.SubComponentName',
														'subComponentCategories.SubComponentCategoryName',
														'projectSectorInterventions.SectorInterventionName',
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

										<div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
											<h4 class="form-section">Documentation</h4>
											
										</div>

										<div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
											<h4 class="form-section">Beneficiaries</h4>								
										</div>

										<div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
											<h4 class="form-section">Stakeholder Consultation and Inclusion</h4>								
										</div>

										<div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
											<h4 class="form-section">Grievance Management</h4>			
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

										<div class="tab-pane" id="tab6" aria-labelledby="base-tab6">
											<h4 class="form-section">Land Acquisition</h4>								
										</div>

										<div class="tab-pane" id="tab19" aria-labelledby="base-tab19">
											<h4 class="form-section">Security Issues</h4>								
										</div>

										<div class="tab-pane" id="tab8" aria-labelledby="base-tab8">
											<h4 class="form-section">E&S Impacts</h4>								
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