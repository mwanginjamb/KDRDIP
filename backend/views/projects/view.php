<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\projects */

$this->title = $model->ProjectName;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->ProjectID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ProjectID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) ?>
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
											<a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5" aria-expanded="false">Safeguarding Policies</a>
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
											<a class="nav-link" id="base-tab10" data-toggle="tab" aria-controls="tab10" href="#tab10" aria-expanded="false">Budget</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="base-tab11" data-toggle="tab" aria-controls="tab11" href="#tab11" aria-expanded="false">Notes</a>
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
													'ProjectCost',
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
													[
														'attribute' => 'ProjectFundingID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
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
													[
														'attribute' => 'ProjectRiskID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
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
														'attribute' => 'ProjectDisbursementID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													],
													[
														'label'=>'Year',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'Year',
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
											<h4 class="form-section">Safeguarding Policies</h4>												
											<?= GridView::widget([
												'dataProvider' => $projectSafeguardingPolicies,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'attribute' => 'ProjectSafeguardingPolicyID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
													],
													[
														'label'=>'Safeguarding Policy',
														'headerOptions' => ['style'=>'color:black; text-align:left'],
														'format'=>'text',
														'value' => 'safeguardingPolicies.SafeguardingPolicyName',
														'contentOptions' => ['style' => 'text-align:left'],
													],													
												],
											]); ?>
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
													[
														'attribute' => 'ProjectBeneficiaryID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
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
													[
														'attribute' => 'ProjectTeamID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
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
												<?= Html::a('<i class="ft-plus"></i> New Indicator', ['indicators/create', 'pid' => $model->ProjectID], ['class' => 'btn-sm btn-primary mr-1']) ?>	 
											</div>
											<!-- <table class="table table-striped table-bordered dataex-key-basic">
											<thead>
												<tr>
													<th>Name</th>
													<th>Position</th>
													<th>Office</th>
													<th>Age</th>
													<th>Start date</th>
													<th>Salary</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											foreach ($indicators->models as $key => $indicator) { ?>
												<tr>
													<td>Tiger Nixon</td>
													<td>System Architect</td>
													<td>Edinburgh</td>
													<td>61</td>
													<td>2011/04/25</td>
													<td>$320,800</td>
												</tr>												
												<?php
											} ?>
											</tbody>
											</table> -->
											<?= GridView::widget([
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
											]); ?>
										</div>

										<div class="tab-pane" id="tab9" aria-labelledby="base-tab9">
											<h4 class="form-section">Targets</h4>
											<table class="custom-table table-striped table-bordered"><thead>
											<tr>
												<th width="5%" style="color:black; text-align:center">ID</th>
												<th style="color:black; text-align:left">Indicator</th>
												<th>Unit Of Measure Name</th>
												<th>Base Line</th>
												<th>End Target</th>
												<th>Sub Component Name</th>
												<th width="8%" style="color:black; text-align:center">&nbsp;</th>
											</tr>
											</thead>
												<tbody>
												<tr>
													<td style="text-align:center">2</td>
													<td style="text-align:left"></td>
													<td>Number</td><td>1121.00</td>
													<td>3343.00</td><td>test</td>
													<td></td>
												</tr>
												</tbody>
											</table>
										</div>

										<div class="tab-pane" id="tab10" aria-labelledby="base-tab10">
											<!-- <h4 class="form-section">Budget</h4> -->
											<?= $this->render('/budget/index', ['pid' => $model->ProjectID, 'dataProvider' => $budgetProvider]); ?>
										</div>

										<div class="tab-pane" id="tab11" aria-labelledby="base-tab11">
											<h4 class="form-section">Notes</h4>	 
											<?= GridView::widget([
												'dataProvider' => $projectNotes,
												'showFooter' =>false,
												'layout' => '{items}',
												'tableOptions' => [
													'class' => 'custom-table table-striped table-bordered',
												],
												'columns' => [
													[
														'attribute' => 'ProjectNoteID',
														'label' => 'ID',
														'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
														'contentOptions' => ['style' => 'text-align:center'],
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
