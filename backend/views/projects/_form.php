<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\projects */
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
					<a class="nav-link" id="base-tab8" data-toggle="tab" aria-controls="tab8" href="#tab8" aria-expanded="false">Notes</a>
				</li>
				
			</ul>
			<div class="tab-content px-1 pt-1">
				<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
					<h4 class="form-section">Details</h4>	 
					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'ProjectName')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'ProjectParentID')->dropDownList($projects, ['prompt'=>'Select']); ?>
						</div>			
					</div>

					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'Objective')->textarea(['rows' => 4]) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'Justification')->textarea(['rows' => 4]) ?>	
						</div>			
					</div>

					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'ProjectCost')->textInput(['maxlength' => true, 'type' => 'number']) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'ApprovalDate')->textInput(['type' => 'date']) ?>	
						</div>			
					</div>

					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'StartDate')->textInput(['type' => 'date']) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'EndDate')->textInput(['type' => 'date']) ?>
						</div>			
					</div>

					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'ProjectStatusID')->dropDownList($projectStatus, ['prompt'=>'Select']); ?>
						</div>
						<div class="col-md-6">
							
						</div>			
					</div>
				</div>
				<div class="tab-pane" id="tab2" aria-labelledby="base-tab12">
					<h4 class="form-section">Finance Sources</h4>

					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">Funding Source</td>
						<td style="padding: 4px !important" width="20%">Amount</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectFunding as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectFundingID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>
							<td><?= $form->field($column, '[' . $x . ']FundingSourceID', ['template' => '{label}{input}'])->dropDownList($fundingSources, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']Amount')->textInput(['class' => 'form-control'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table> 
						
				</div>
				<div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
					<h4 class="form-section">Risk</h4>									
					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">Risk</td>
						<td style="padding: 4px !important" width="15%">Risk Rating</td>
						<td style="padding: 4px !important" width="15%">Risk Likelihood</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectRisk as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectRiskID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>							
							<td><?= $form->field($column, '[' . $x . ']ProjectRiskName')->textInput(['class' => 'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']RiskRatingID', ['template' => '{label}{input}'])->dropDownList($riskRating, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']RiskLikelihoodID', ['template' => '{label}{input}'])->dropDownList($riskLikelihood, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table> 
				</div>
				<div class="tab-pane" id="tab4" aria-labelledby="base-tab4">
					<h4 class="form-section">Disbursement</h4>
					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">Year</td>
						<td style="padding: 4px !important" width="20%">Amount</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectDisbursement as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectDisbursementID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>							
							<td><?= $form->field($column, '[' . $x . ']Year')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']Amount')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table> 
					
				</div>
				<div class="tab-pane" id="tab5" aria-labelledby="base-tab5">
					<h4 class="form-section">Safeguarding Policies</h4>												
					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">Safeguarding Policy</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectSafeguardingPolicies as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectSafeguardingPolicyID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>
							<td><?= $form->field($column, '[' . $x . ']SafeguardingPolicyID', ['template' => '{label}{input}'])->dropDownList($safeguardingpolicies, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table>
				</div>
				<div class="tab-pane" id="tab6" aria-labelledby="base-tab6">
					<h4 class="form-section">Beneficiaries</h4>	 
					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">County</td>
						<td style="padding: 4px !important" width="30%">Sub County</td>
						<td style="padding: 4px !important" width="15%">Host Population</td>
						<td style="padding: 4px !important" width="15%">Refugee Population</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectBeneficiaries as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectBeneficiaryID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>
							<td><?= $form->field($column, '[' . $x . ']CountyID', ['template' => '{label}{input}'])->dropDownList($counties, ['prompt'=>'','class'=>'form-control',
														'onchange' => '
														$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {

															$( "select#projectbeneficiaries-' . $x . '-subcountyid" ).html( data );
														});
													'])->label(false) ?>
							</td>
							<td><?= $form->field($column, '[' . $x . ']SubCountyID', ['template' => '{label}{input}'])->dropDownList(isset($subCounties[$column->CountyID]) ? $subCounties[$column->CountyID] : [], ['prompt'=>'', 'class'=>'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']HostPopulation')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']RefugeePopulation')->textInput(['class' => 'form-control', 'type' => 'number'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table>
				</div>
				<div class="tab-pane" id="tab7" aria-labelledby="base-tab7">
					<h4 class="form-section">Project Team</h4>
					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">Team Member</td>
						<td style="padding: 4px !important" width="15%">Role</td>
						<td style="padding: 4px !important" width="30%">Specialization</td>
						<td style="padding: 4px !important" width="15%">Unit</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectTeams as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectTeamID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>
							<td><?= $form->field($column, '[' . $x . ']ProjectTeamName')->textInput(['class' => 'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']ProjectRoleID', ['template' => '{label}{input}'])->dropDownList($projectRoles, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']Specialization')->textInput(['class' => 'form-control'])->label(false) ?></td>
							<td><?= $form->field($column, '[' . $x . ']ProjectUnitID', ['template' => '{label}{input}'])->dropDownList($projectUnits, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table>	 
					
				</div>

				<div class="tab-pane" id="tab8" aria-labelledby="base-tab8">
					<h4 class="form-section">Notes</h4>	 
					<table width="100%" class="custom-table" id="ColumnsTable">
					<thead>
					<tr>
						<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
						<td style="padding: 4px !important">Notes</td>
					</tr>	
					</thead>
					<?php
					foreach ($projectNotes as $x => $column) {
						?>
						<tr>
							<td style="text-align: center;">
								<?= $x+1; ?>
								<?= $form->field($column, '[' . $x . ']ProjectNoteID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
							</td>
							<td><?= $form->field($column, '[' . $x . ']Notes')->textInput(['class' => 'form-control'])->label(false) ?></td>
						</tr>
						<?php
					} ?>
					</table>
				</div>
			</div>			

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
