<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;

	//print_r($dataProvider); exit;
	$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
		
		<?php
		//print_r($stocktake); Exit;
		if ($Filter) {
			$form = ActiveForm::begin([
			'id' => 'contact-form',
				'fieldConfig' => [
					'options' => ['tag' => false, ],
					'enableClientValidation'=> false,
					'enableAjaxValidation'=> false,
				],
			]);
			if (isset($report) && $report == 'projects-report') { ?>
				<div class="row">
					<div class="col-lg-3">
						<?= $form->field($model, 'ProjectStatusID')->dropDownList($projectStatus, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'ComponentID')->dropDownList($components, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'ProjectSectorID')->dropDownList($projectSectors, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt'=>'All...', 'onchange' => '
							$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {
								$( "select#filterdata-subcountyid" ).html( data );
							});
						']); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						<?= $form->field($model, 'SubCountyID')->dropDownList($subCounties, ['prompt'=>'All...', 'onchange' => '
							$.post( "' . Yii::$app->urlManager->createUrl('projects/locations?id=') . '"+$(this).val(), function( data ) {
								$( "select#filterdata-locationid" ).html( data );
							});
						']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'LocationID')->dropDownList($locations, ['prompt'=>'All...', 'onchange' => '
							$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-locations?id=') . '"+$(this).val(), function( data ) {
								$( "select#filterdata-sublocationid" ).html( data );
							});
						']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'SubLocationID')->dropDownList($subLocations, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-3">
						<div class="form-group" style="padding-top:15px">
						<?= Html::submitButton('<i class="ft-search"></i> Filter', ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
				</div>
				<?php
			} elseif (isset($report) && $report == 'projects-cummulative-expenditure') { ?>
				<div class="row">
					<div class="col-lg-3">
						<?= $form->field($model, 'ProjectStatusID')->dropDownList($projectStatus, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'ComponentID')->dropDownList($components, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-2">
						<?= $form->field($model, 'StartDate')->textInput(['type' => 'date']) ?>
					</div>
					<div class="col-lg-2">
						<?= $form->field($model, 'EndDate')->textInput(['type' => 'date']) ?>
					</div>
					<div class="col-lg-2">
						<div class="form-group" style="padding-top:15px">
						<?= Html::submitButton('<i class="ft-search"></i> Filter', ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
				</div>				
				<?php
			} elseif (isset($report) && $report == 'component-finance-report') { ?>
				<?php
			} elseif (isset($report) && ($report == 'component1-report' || $report == 'component2-report' || $report == 'component3-report')) { ?>
				<div class="row">
					<div class="col-lg-3">
						<?= $form->field($model, 'CountyID')->dropDownList($counties, ['prompt'=>'All...', 'onchange' => '
							$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-counties?id=') . '"+$(this).val(), function( data ) {
								$( "select#filterdata-subcountyid" ).html( data );
							});
						']); ?>
					</div>
					<div class="col-lg-3">
						<?= $form->field($model, 'SubCountyID')->dropDownList($subCounties, ['prompt'=>'All...', 'onchange' => '
							$.post( "' . Yii::$app->urlManager->createUrl('projects/locations?id=') . '"+$(this).val(), function( data ) {
								$( "select#filterdata-locationid" ).html( data );
							});
						']); ?>
					</div>
					<div class="col-lg-2">
						<?= $form->field($model, 'LocationID')->dropDownList($locations, ['prompt'=>'All...', 'onchange' => '
							$.post( "' . Yii::$app->urlManager->createUrl('projects/sub-locations?id=') . '"+$(this).val(), function( data ) {
								$( "select#filterdata-sublocationid" ).html( data );
							});
						']); ?>
					</div>
					<div class="col-lg-2">
						<?= $form->field($model, 'SubLocationID')->dropDownList($subLocations, ['prompt'=>'All...']); ?>
					</div>
					<div class="col-lg-2">
						<div class="form-group" style="padding-top:15px">
						<?= Html::submitButton('<i class="ft-search"></i> Filter', ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
				</div>
				<?php
			} else { ?>
				<div class="row">
					<div class="col-lg-3">
						<?php
						if (isset($StockFilter) && $StockFilter == true) {
							echo $form->field($model, 'StockTakeID')->dropDownList($stocktake, ['prompt'=>'All...']);
						} elseif (isset($SupplierFilter) && $SupplierFilter == true && isset($suppliers) && (count($suppliers) > 0)) {
							echo $form->field($model, 'SupplierID')->dropDownList($suppliers, ['prompt'=>'All...']);
						} elseif (count($productcategories) > 0) {
							echo $form->field($model, 'ProductCategoryID')->dropDownList($productcategories, ['prompt'=>'All...']);
						} elseif (isset($bankAccounts) && count($bankAccounts) > 0) {
							echo $form->field($model, 'BankAccountID')->dropDownList($bankAccounts, ['prompt'=>'All...']);
						} elseif (isset($projectStatus) && count($projectStatus) > 0) {
							echo $form->field($model, 'ProjectStatusID')->dropDownList($projectStatus, ['prompt'=>'All...']);
						} elseif (isset($projects) && count($projects) > 0) {
							echo $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt'=>'All...'])->label('Sub Project');
						}
						?>
					</div>
					<?php if (isset($projects) && count($projects) > 0 && isset($SupplierFilter) && $SupplierFilter) { ?>
						<div class="col-lg-3">
							<?= $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt'=>'All...'])->label('Sub Project'); ?>
						</div>
					<?php } ?>
					<?php
					if (isset($components) && count($components) > 0) { ?>
						<div class="col-lg-3">
							<?= $form->field($model, 'ComponentID')->dropDownList($components, ['prompt'=>'All...']); ?>
						</div>
						<?php
					}
					?>
					<?php
					if (!$CategoryFilterOnly) { ?>
						<div class="col-lg-3">
							<?= $form->field($model, 'Month')->dropDownList($months, ['prompt'=>'All...']) ?>
						</div>
						<div class="col-lg-3">
							<?= $form->field($model, 'Year')->dropDownList($years, []) ?>
						</div>
						
						<?php
					} ?>
					<div class="col-lg-3">
						<div class="form-group" style="padding-top:15px">
						<?= Html::submitButton('<i class="ft-search"></i> Filter', ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
				</div>
				<?php
			} ?>

			<?php ActiveForm::end();
		}
		?>
		<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
	</div>	
</section>