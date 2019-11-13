<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StockTake */
/* @var $form yii\widgets\ActiveForm */
$Rights = Yii::$app->params['rights'];
$FormID = 11;
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

			<?php $form = ActiveForm::begin([
			'id' => 'stocktake-form',
				'fieldConfig' => [
					'options' => ['tag' => false, ],
					'enableClientValidation'=> false,
					'enableAjaxValidation'=> false,
				],
			]); 
			?>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Reason')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 3]) ?>
				</div>			
			</div>

			<?php 
			if (!$model->isNewRecord)
			{ ?>
				<table width="100%" class="custom-table table-striped table-bordered-min">
				<thead>
				<tr>
					<th style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</th>
					<th style="padding: 4px 4px 4px 4px !important;" width="5%">ID</th>
					<th style="padding: 4px 4px 4px 4px !important">Product</th>
					<th style="padding: 4px 4px 4px 4px !important" width="20%">Category</th>
					<th style="padding: 4px 4px 4px 4px !important" width="15%">Usage Unit</th>
					<th style="padding: 4px 4px 4px 4px !important; text-align:right" width="10%">Current Stock</th>
					<th style="padding: 4px 4px 4px 4px !important; text-align:right;" width="10%">Physial Stock</th>
				</tr>	
				</thead>
				<?php 
				foreach ($lines as $x => $line) 
				{ 
					?>
					<tr>
						<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '['.$x.']StockTakeLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
						<td style="padding: 4px 4px 4px 4px !important;"><?= $line['ProductID']; ?></td>
						<td style="padding: 4px 4px 4px 4px !important;"><?= $line['product']['ProductName']; ?></td>
						<td style="padding: 4px 4px 4px 4px !important;"><?= $line['product']['productcategory']['ProductCategoryName'];?></td>
						<td style="padding: 4px 4px 4px 4px !important;"><?= $line['product']['usageunit']['UsageUnitName'];?></td>
						<td style="padding: 4px 4px 4px 4px !important; text-align:right"><?= $line['CurrentStock']; ?></td>
						<td><?= $form->field($line, '['.$x.']PhysicalStock', ['template' => '{label}{input}'])->textInput(['style'=> 'text-align:right', 'class'=>'form-control-min'])->label(false) ?></td>
					</tr>
					<?php
				} ?>
				</table>
				<?php
			} ?>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
