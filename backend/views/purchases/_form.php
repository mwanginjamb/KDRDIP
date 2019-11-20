<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;



/* @var $this yii\web\View */
/* @var $model app\models\Purchases */
/* @var $form yii\widgets\ActiveForm */

//actionGetunitprice($SupplierID, $ProductID, $SupplierCode)
$baseUrl = Yii::$app->request->baseUrl;
//echo $baseUrl; exit;

$Rights = Yii::$app->params['rights'];
$FormID = 5;
$disabled = ($model->isNewRecord) ? false : true;
//$disabled = false;
$url = Url::home(true);
?>
<script>
function fetch_data(url)
{
	xmlhttp=GetXmlHttpObject()
	if (xmlhttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	rest = xmlhttp.responseText;
	//alert(rest);
	var obj = JSON.parse(rest);
	return obj;	
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		//Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function populate_unitprice(row, supplierid)
{
	console.log(productid);
	console.log(row);
	
	var productid = document.getElementById("purchaselines-"+row+"-productid").value;
	
	var suppliercode = document.getElementById("purchaselines-"+row+"-suppliercode").value;
	
	var url = '<?= $baseUrl; ?>/purchases/getunitprice?SupplierID='+supplierid+'&ProductID='+productid+'&SupplierCode='+suppliercode;
	
	var obj = fetch_data(url);
	var unitprice = 0;
	if (obj.UnitPrice)
	{
		unitprice = obj.UnitPrice;
	}
	var quantity = document.getElementById("purchaselines-"+row+"-quantity").value;
	
	if (isNaN(quantity))
	{
		quantity = 0;
	} 
	var total = unitprice*quantity;
	document.getElementById("purchaselines-"+row+"-unitprice").value = unitprice.toLocaleString('en');
	document.getElementById("purchaselines-"+row+"-unit_total").value = total.toLocaleString('en');
	//console.log(document.getElementById("purchaselines-1-unitprice").value);
}

function addRow() 
{
	var table = document.getElementById("PurchaseTable");
	var rows = table.getElementsByTagName("tr").length;
	var row = table.insertRow(rows);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var cell6 = row.insertCell(5);
	var cell7 = row.insertCell(6);
	
	var fields = fetch_data1('<?= $url;?>/purchases/getfields?id='+rows+'&SupplierID=<?= $model->SupplierID; ?>');
	//console.log(fields);
	cell1.innerHTML = fields[0];
	cell2.innerHTML = fields[1];
	cell3.innerHTML = fields[2];
	cell4.innerHTML = fields[3];
	cell5.innerHTML = fields[4];
	cell6.innerHTML = fields[5];
	cell7.innerHTML = fields[6];
	cell1.style.textAlign = 'center';
}

function myDeleteFunction() {
	document.getElementById("PurchaseTable").deleteRow(0);
} 
</script>

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
    'id' => 'contact-form',
		'fieldConfig' => [
			'options' => ['tag' => false, ],
			'enableClientValidation'=> false,
			'enableAjaxValidation'=> false,
		],
	]); 
	?>
	<table width="100%">
	<tr> 
		<td width="50%">
			<?= $form->field($model, 'SupplierID')->dropDownList($suppliers, ['prompt'=>'Select...', 'disabled' => $disabled]) ?>
		</td>
		<td>
			<?= $form->field($model, 'QuotationID')->dropDownList($quotations, ['prompt'=>'Select...', 'disabled' => $disabled]) ?>
		</td>
    </tr>
	</table>
	<?php 
	if (!$model->isNewRecord)
	{ ?>
		<table width="100%" class="custom-table table-striped table-bordered-min" id="PurchaseTable">
		<thead>
		<tr>
			<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
			<td style="padding: 4px 4px 4px 4px !important">Product</td>
			<td style="padding: 4px 4px 4px 4px !important" width="15%">Code</td>
			<td style="padding: 4px 4px 4px 4px !important" width="15%">Quantity</td>
			<td style="padding: 4px 4px 4px 4px !important" width="15%">Usage Unit</td>
			<td style="padding: 4px 4px 4px 4px !important" width="15%">Unit Price</td>
			<td style="padding: 4px 4px 4px 4px !important; text-align:right;" width="15%">Total</td>
		</tr>	
		</thead>
		<?php 
		foreach ($lines as $x => $line) 
		{ 
			$_ProductID = isset($line['ProductID']) ? $line['ProductID'] : 0;
			?>
			<tr>
				<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '['.$x.']PurchaseLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
				<td><?= $form->field($line, '['.$x.']ProductID', ['template' => '{label}{input}'])->dropDownList($products,['prompt'=>'','class'=>'form-control', 'onchange'=>'populate_unitprice('.$x.','.$model->SupplierID.')'])->label(false) ?></td>
				<td><?= $form->field($line, '['.$x.']SupplierCode', ['template' => '{label}{input}'])->dropDownList($pricelist,['prompt'=>'','class'=>'form-control', 'onchange'=>'populate_unitprice(this.value, '.$x.','.$model->SupplierID.')'])->label(false) ?></td>
				<td><?= $form->field($line, '['.$x.']Quantity', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'onchange'=>'populate_unitprice('.$x.','.$model->SupplierID.')'])->label(false) ?></td>
				<td><?= $form->field($line, '['.$x.']UsageUnitID', ['template' => '{label}{input}'])->dropDownList($usageunits,['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
				<td><?= $form->field($line, '['.$x.']UnitPrice', ['template' => '{label}{input}'])->textInput(['readonly' => 'true', 'style'=> 'text-align:right', 'class'=>'form-control-min'])->label(false) ?></td>
				<td><?= $form->field($line, '['.$x.']Unit_Total', ['template' => '{label}{input}'])->textInput(['disabled' => 'true', 'style'=> 'text-align:right', 'class'=>'form-control-min'])->label(false) ?></td>
			</tr>
			<?php
		} ?>
		</table>
		<?php
	} ?>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?>
		</div>
		<div class="col-md-6">
			<?= (!$model->isNewRecord) ? Html::button('<i class="ft-plus"></i> Add Row', [ 'class' => 'btn btn-primary', 'onclick' => 'addRow()' ]) : ''; ?>	
		</div>			
	</div>
	<p></p>
	<div class="form-group">
		<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
		<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
		<?php $i=0; 
		if ($i==1) {
			echo Html::a('Send for Approval', ['submit', 'id' => $model->PurchaseID], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to submit this item?',
				'method' => 'post',
			],
		]);
		} ?>
	</div>

    <?php ActiveForm::end(); ?>

	 </div>
</div>

