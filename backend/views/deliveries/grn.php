<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Purchases */

$this->title = 'View GRN :'.$model->DeliveryID;
$this->params['breadcrumbs'][] = $this->title;

$Total = 0;
/*
if (!empty($dataProvider->getModels())) 
{
	foreach ($dataProvider->getModels() as $key => $val) 
	{
		$Total += $val->Unit_Total;
    }
}
$Total = number_format($Total,2);
*/
?>
<section>
	<div class="container">
		<table width="100%">
			<tr>
				<td style="text-align:right; font-weight:bold; vertical-align: top;">
					<h5>GOODS RECEIVED NOTE</h5>
				</td>
			</tr>			
		</table>
		<div style="padding-top:20px"></div>
		<table width="100%">
			<tr>
				<td width="70%" style="text-align:left; vertical-align: top;">
					<p style="font-weight:bold">Supplier</p>
					<p><?= $model->purchases->suppliers->SupplierName; ?></p>
					<div style="padding-top:20px"></div>
					<p>P.O. Box <?= $model->purchases->suppliers->PostalAddress; ?></p>
					<p><?= $model->purchases->suppliers->PostalCode.' '.$model->purchases->suppliers->Town. ' '. $model->purchases->suppliers->CompanyID; ?></p>
					<p><?= $model->purchases->suppliers->Telephone; ?></p>
					<p><?= $model->purchases->suppliers->Mobile; ?></p>
					<p><?= $model->purchases->suppliers->Email; ?></p>
				</td>
				<td style="text-align:left; vertical-align: top;">
					<table width="100%">
					<tr>
						<td width="50%">GRN Number</td>
						<td width="50%"> : <?= $model->DeliveryID; ?></td>
					</tr>
					<tr>
						<td>GRN Date</td>
						<td> : <?= date('d/m/Y',strtotime($model->PostingDate)); ?></td>
					</tr>	
					<tr>
						<td>P.O. Number</td>
						<td> : <?= $model->PurchaseID; ?></td>
					</tr>
					<tr>
						<td>P.O. Date</td>
						<td> : <?= date_format(date_create($model->PostingDate),'d/m/Y'); ?></td>
					</tr>					
					</table>					
				</td>
			</tr>			
		</table>
		<div style="padding-top:20px"></div>
	
	<table width="100%" class="table table-striped table-bordered-min">
	<thead>
	<tr>
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: center;" width="5%">#</td>
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold;" width="15%">Code</td>
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold;">Product</td>
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold;" width="15%">Usage Unit</td>			
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: right" width="15%">Ordered</td>
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: right" width="15%">Received T.D.</td>
		<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: right" width="15%">Delivered</td>
	</tr>	
	</thead>
	<?php 
	foreach ($lines as $x => $line) 
	{ ?>
		<tr>
			<td style="padding: 4px 4px 4px 4px !important; text-align: center;">
			<?= $x+1; ?></td>
			<td style="padding: 4px 4px 4px 4px !important"><?= $data[$x]['SupplierCode']; ?></td>
			<td style="padding: 4px 4px 4px 4px !important" ><?= $data[$x]['ProductName']; ?></td>
			<td style="padding: 4px 4px 4px 4px !important" ><?= $data[$x]['UsageUnitName']; ?></td>
			<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= $data[$x]['Quantity']; ?></td>
			<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= isset($delivered[$data[$x]['PurchaseLineID']]) ? $delivered[$data[$x]['PurchaseLineID']] : 0; ?></td>
			<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= $data[$x]['DeliveredQuantity']; ?></td>
		</tr>
		<?php
	} ?>
	</table>
		<div style="padding-top:20px"></div>
		<div style="border-bottom: 1px solid black; border-width:0.01em; padding-bottom:3px; margin-bottom:10px"></div>

	</div>
</section>
