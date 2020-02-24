<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$url = Url::home(true);

/* @var $this yii\web\View */
/* @var $model app\models\Safeguards */
/* @var $form yii\widgets\ActiveForm */
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

function addRow() 
{
	var table = document.getElementById("ParameterTable");
	var rows = table.getElementsByTagName("tr").length;
	var row = table.insertRow(rows);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	
	var fields = fetch_data1('<?= $url;?>/safeguards/getfields?id='+rows);
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
			<?php $form = ActiveForm::begin(); ?>
	 
	 		<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'SafeguardName')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>
			<h4 class="form-section" style="margin-bottom: 0px">Parameters</h4>
			<table width="100%" class="custom-table table-bordered-min" id="ParameterTable">
			<thead>
			<tr>
				<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
				<td style="padding: 4px 4px 4px 4px !important">Parameter</td>
			</tr>	
			</thead>
			<?php 
			foreach ($parameters as $x => $line) 
			{ ?>
				<tr>
					<td style="text-align: center;"><?= $x+1; ?><?= $form->field($line, '[' . $x . ']SafeguardParamaterID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
					<td><?= $form->field($line, '['.$x.']SafeguardParamaterName', ['template' => '{label}{input}'])->textInput(['class'=>'form-control'])->label(false) ?></td>
				</tr>
				<?php
			} ?>			
			</table>
			<?= Html::button('Add Row', [ 'class' => 'bigbtn btn-primary', 'style' => 'float:right', 'onclick' => 'addRow()' ]); ?>
			<p></p>

			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'Notes')->textarea(['rows' => 3]) ?>
				</div>
				<div class="col-md-6">
						
				</div>			
			</div>

			<div class="form-group">
				<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
				<?= Html::submitButton('<i class="la la-check-square-o"></i> Save', ['class' => 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

	 </div>
</div>
