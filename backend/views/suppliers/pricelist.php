<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Price List';
$baseUrl = Yii::$app->request->baseUrl;
$url = $baseUrl.'/suppliers/uploadpricelist?id='.$supplier->SupplierID;
$url2 = $baseUrl.'/suppliers/pricelist?id='.$supplier->SupplierID;

$Rights = Yii::$app->params['rights'];
$FormID = 21;
?>
	<p>
	<div id="msg" style="color:red"></div></p>
	<div class="row">
		<div class="col-lg-6" style="padding-bottom:10px">			
			<?= Html::a('<i class="ft-upload"></i> Upload', ['uploadpricelist', 'id' => $supplier->SupplierID], [ 'class' => 'btn btn-primary place-right']); ?>
			<?= Html::a('<i class="ft-download"></i> Download Template', ['downloadtemplate'], [ 'class' => 'btn btn-success place-right', 'style' => 'width: 180px !important; margin-right: 10px;']); ?>
		</div>
	</div>	
	
    <?php $form = ActiveForm::begin([
    'id' => 'supplier-form',
			'fieldConfig' => [
			'options' => ['tag' => false, ],
			'enableClientValidation'=> false,
			'enableAjaxValidation'=> false,
		],
	]); 
	?>
		<table width="100%" class="custom-table table-bordered-min" style="padding-right:20px !important">
		<thead>
		<tr>
			<td style="padding: 4px 4px 4px 15px !important; font-weight: bold" width="10%">Code</td>
			<td style="padding: 4px 4px 4px 15px !important; font-weight: bold" >Product Name</td>
			<td style="padding: 4px 4px 4px 15px !important; font-weight: bold" width="14%">Unit of Measure</td>
			<td style="padding: 4px 15px 4px 4px !important; text-align:right; font-weight: bold" width="12%">Price</td>
		</tr>	
		</thead>
		<?php 
		foreach ($products as $x => $product) 
		{ ?>
			<tr>
				<td><?= $form->field($product, '['.$x.']SupplierCode', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?>
					<?= $form->field($product, '['.$x.']PriceListID', ['template' => '{label}{input}'])->hiddenInput(['class'=>'form-control'])->label(false);?>
				</td>
				<td><?= $form->field($product, '['.$x.']ProductName', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
				<td><?= $form->field($product, '['.$x.']UnitofMeasure', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
				<td><?= $form->field($product, '['.$x.']Price', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'style' => 'text-align:right', 'type' => 'amount'])->label(false) ?></td>
			</tr>
			<?php
		} 
		if (count($products) == 0)
		{ ?>
			<tbody>
			<tr>
				<td colspan="4" style="text-align:center">No items to display</td>
			</tr>
			</tbody>
			<?php
		}
		?>
		
		</table>
		<?php
		if (count($products) > 0)
		{ ?>
			<div class="form-group">
				<?= ($Rights[$FormID]['View']) ? Html::button('Save', [ 'class' => 'bigbtn btn-primary', 'onclick' => 'saverecords(\''.$url2.'\',\'details\',\''.$supplier->SupplierID.'\',\''.$baseUrl.'\',1)' ]) : ''; ?>
				
			</div>
			<?php
		} ?>

    <?php ActiveForm::end(); ?>
