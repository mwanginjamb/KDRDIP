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
			?>
			<div class="row">
				<div class="col-lg-3">
					<?php
					if (isset($StockFilter) && $StockFilter == true) {
						echo $form->field($model, 'StockTakeID')->dropDownList($stocktake, ['prompt'=>'All...']);
					} elseif (isset($SupplierFilter) && $SupplierFilter == true) {
						echo $form->field($model, 'SupplierID')->dropDownList($suppliers, ['prompt'=>'All...']);
					} elseif (count($productcategories) > 0) {
						echo $form->field($model, 'ProductCategoryID')->dropDownList($productcategories, ['prompt'=>'All...']);
					} elseif (isset($bankAccounts) && count($bankAccounts) > 0) {
						echo $form->field($model, 'BankAccountID')->dropDownList($bankAccounts, ['prompt'=>'All...']);
					} elseif (isset($projects) && count($projects) > 0) {
						echo $form->field($model, 'ProjectID')->dropDownList($projects, ['prompt'=>'All...']);
					} elseif (isset($projectStatus) && count($projectStatus) > 0) {
						echo $form->field($model, 'ProjectStatusID')->dropDownList($projectStatus, ['prompt'=>'All...']);
					}
					?>
				</div>
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

			<?php ActiveForm::end();
		}
		?>
		<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
	</div>	
</section>