<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @var $form yii\widgets\ActiveForm */
$Rights = Yii::$app->params['rights'];
$FormID = 25;

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

function addProductRow() 
{
    var table = document.getElementById("ProductTable");
	var rows = table.getElementsByTagName("tr").length;
    var row = table.insertRow(rows);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	
	var fields = fetch_data1('<?= $url;?>/quotation/getproductsfields?id='+rows);
	//console.log(fields);
    cell1.innerHTML = fields[0];
    cell2.innerHTML = fields[1];
	cell3.innerHTML = fields[2];
	
	cell1.style.textAlign = 'center';
}

function addSupplierRow() 
{
    var table = document.getElementById("SupplierTable");
	var rows = table.getElementsByTagName("tr").length;
    var row = table.insertRow(rows);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
	
	var fields = fetch_data1('<?= $url;?>/quotation/getsupplierfields?id='+rows);
	//console.log(fields);
    cell1.innerHTML = fields[0];
    cell2.innerHTML = fields[1];
	
	cell1.style.textAlign = 'center';
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
			]); ?>
	 
	 		<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Description')->textInput() ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'RequisitionID')->dropDownList($requisitions, ['prompt'=>'Select...']) ?>
				</div>			
			</div>

			<h4 class="form-section" style="margin-bottom: 0px">Select Products</h4>
			<table width="100%" class="custom-table table-striped table-bordered-min" id="ProductTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important" width="25%">Type</td>
				<td style="padding: 4px 4px 4px 4px !important">Product</td>
				<td style="padding: 4px 4px 4px 4px !important" width="25%">Quantity</td>
			</tr>	
			</thead>
			<?php 
			foreach ($lines as $x => $line) { ?>
				<tr>
					<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '[' . $x . ']QuotationProductID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
					<td><?= $form->field($line, '[' . $x . ']QuotationTypeID', ['template' => '{label}{input}'])->dropDownList($quotationTypes, ['prompt'=>'', 'class'=>'form-control',
															'onchange'=>'
															$.post( "' . Yii::$app->urlManager->createUrl('quotation/get-types?id=').'"+$(this).val()+"&TypeID="+$("#quotationproducts-'.$x.'-quotationtypeid").val(), 
															function( data ) {
																$( "select#quotationproducts-'.$x.'-productid" ).html( data );
															});
														'])->label(false) ?>
					</td>					
					<td><?= $form->field($line, '[' . $x . ']ProductID', ['template' => '{label}{input}'])->dropDownList(isset($products[$line->QuotationTypeID]) ? $products[$line->QuotationTypeID] : [], ['prompt'=>'', 'class'=>'form-control'])->label(false) ?></td>					
					<td><?= $form->field($line, '[' . $x . ']Quantity', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'type' => 'number'])->label(false) ?></td>
				</tr>
				<?php
			} ?>
			</table>
			<div style="height:30px">
				<?= Html::button('Add Row', [ 'class' => 'bigbtn btn-primary', 'style' => 'float:right', 'onclick' => 'addProductRow()' ]); ?>
			</div>

			<h4 class="form-section" style="margin-bottom: 0px">Select Suppliers</h4>
			<table width="100%" class="custom-table table-striped table-bordered-min" id="SupplierTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important">Supplier</td>
			</tr>	
			</thead>
			<?php 
			foreach ($quotationsuppliers as $x => $line) 
			{ ?>
				<tr>
					<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '[' . $x . ']QuotationSupplierID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
					<td><?= $form->field($line, '[' . $x . ']SupplierID', ['template' => '{label}{input}'])->dropDownList($suppliers, ['prompt'=>'','class'=>'form-control'])->label(false) ?></td>
				</tr>
				<?php
			} ?>			
			</table>
			<?= Html::button('Add Row', [ 'class' => 'bigbtn btn-primary', 'style' => 'float:right', 'onclick' => 'addSupplierRow()' ]); ?>
			<p></p>
			
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>
			<p></p>

			<div class="form-actions" style="margin-top:0px">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
