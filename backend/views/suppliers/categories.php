<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Categories';
$baseUrl = Yii::$app->request->baseUrl;
/* $url = $baseUrl.'/suppliers/categories?id='.$supplier->SupplierID;
$url2 = $baseUrl.'/suppliers/categories?id='.$supplier->SupplierID; */

$Rights = Yii::$app->params['rights'];
$FormID = 23;
?>
	<p>
	<div id="msg" style="color:red"></div></p>

    <?php $form = ActiveForm::begin([
    'id' => 'supplier-form',
			'fieldConfig' => [
			'options' => ['tag' => false, ],
			'enableClientValidation'=> false,
			'enableAjaxValidation'=> false,
		],
	]); 
	?>
		<table width="100%" class="custom-table table-striped table-bordered-min" style="padding-right:20px !important">
		<thead>
		<tr>
			<td style="padding: 4px 4px 4px 15px !important; font-weight: bold" width="10%">Code</td>
			<td style="padding: 4px 4px 4px 15px !important; font-weight: bold" >Category Name</td>
			<td style="padding: 4px 4px 4px 15px !important; font-weight: bold"  width="10%">Selected</td>
		</tr>	
		</thead>
		<?php 
		foreach ($categories as $x => $row) 
		{ 
			$category = (object) $row;
			?>
			<tr>
				<td style="padding: 4px 4px 4px 15px !important;"><?= $category->ProductCategoryID; ?>
					<?= $form->field($category, '['.$x.']SupplierCategoryID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
					<?= $form->field($category, '['.$x.']ProductCategoryID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
				</td>
				<td style="padding: 4px 4px 4px 15px !important;"><?= $category->ProductCategoryName; ?></td>
				<td style="text-align:center;"><?= $form->field($category, '['.$x.']Selected', ['template' => '{label}{input}'])->checkBox(['style'=>'margin: 3px 0 0;'])->label(false) ?></td>
			</tr>
			<?php
		} 
		if (count($categories) == 0)
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
		if (count($categories) > 0)
		{ ?>
			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>
			<?php
		} ?>

    <?php ActiveForm::end(); ?>
