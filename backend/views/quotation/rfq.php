<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Purchases */

$this->title = 'View Quotation :'.$model->QuotationID;
$this->params['breadcrumbs'][] = $this->title;
$totalsuppliers = count($suppliers);
?>
<section>
	<div class="container">
		<?php foreach($suppliers as $key => $supplier)
		{ ?>
			<table width="100%">
				<tr>
					<td width="50%" style="text-align:left; vertical-align: top;">
						<p><?= $suppliers[$key]->SupplierName; ?></p>
						<div style="padding-top:20px"></div>
						<p>P.O. Box <?= $suppliers[$key]->PostalAddress; ?></p>
						<p><?= $suppliers[$key]->PostalCode.' '.$suppliers[$key]->Town. ' '. $suppliers[$key]->CompanyID; ?></p>
						<p><?= $suppliers[$key]->Telephone; ?></p>
						<p><?= $suppliers[$key]->Mobile; ?></p>
						<p><?= $suppliers[$key]->Email; ?></p>
					</td>
					<td style="text-align:right; font-weight:bold; vertical-align: top;">
						<h5>REQUEST FOR QUOTATION</h5>
					</td>
				</tr>			
			</table>
			<div style="padding-top:20px"></div>
			<table width="100%">
				<tr>
					<td width="40%" style="text-align:left; vertical-align: top;">
						<p>FROM:</p>
						<p><?= $company->CompanyName; ?></p>
						<p>P.O. Box <?= $company->PostalAddress; ?></p>
						<p><?= $company->PostalCode.' '.$company->Town. ' '. $company->CompanyID; ?></p>
						<p><?= $company->Telephone; ?></p>
						<p><?= $company->Mobile; ?></p>
						<p><?= $company->Email; ?></p>
					</td>
					<td width="40%" style="text-align:left; vertical-align: top;">
						<p>SHIP TO:</p>
						<p><?= $company->CompanyName; ?></p>
						<p>P.O. Box <?= $company->PostalAddress; ?></p>
						<p><?= $company->PostalCode.' '.$company->Town. ' '. $company->CompanyID; ?></p>
						<p><?= $company->Telephone; ?></p>
						<p><?= $company->Mobile; ?></p>
						<p><?= $company->Email; ?></p>
					</td>
					<td style="text-align:left; vertical-align: top;">
						<p>RFQ No.: <?= $model->QuotationID; ?></p>
						<p>Date: <?= date_format(date_create($model->ApprovalDate),'d/m/Y'); ?></p>
					</td>
				</tr>			
			</table>
			<div style="padding-top:20px"></div>
		
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'showFooter' =>true,
				'summary'=>'',
				'columns' => [
					[
						'class' => 'yii\grid\SerialColumn',
						'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
					],				
					[
						'label'=>'Product',
						'headerOptions' => ['style'=>'color:black; text-align:left'],
						'format'=>'text',
						'value' => 'product.ProductName',
						'contentOptions' => ['style' => 'text-align:left'],
						'footer' => 'Total',
						'footerOptions' => ['style' => 'font-weight:bold'],
					],
					[
						'label'=>'Quantity',
						'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
						'format'=>['decimal',2],
						'value' => 'Quantity',
						'contentOptions' => ['style' => 'text-align:right'],
					],		
					[
						'label'=>'Unit Price',
						'headerOptions' => ['width' => '15%','style'=>'color:black; text-align:right'],
						'format'=>'text',
						'value' => 'UnitPrice',
						'contentOptions' => ['style' => 'text-align:right'],
					],	
					[
						'label'=>'Total',
						'headerOptions' => ['width' => '15%','style'=>'color:black; text-align:right'],
						'format'=>'text',
						'value' => 'Unit_Total',
						'contentOptions' => ['style' => 'text-align:right'],
					],			
				],
			]); ?>
			
					<div style="padding-top:20px"></div>
			<div style="border-bottom: 1px solid black; border-width:0.01em; padding-bottom:3px; margin-bottom:10px">Approved By</div>
			<table width="100%">
			<tr>
				<td colspan="2" width="50%" style="text-align:left; vertical-align: top;">
					<div style="padding-bottom:20px"><?= $model->approvers['FullName']; ?></div>
					<div style="padding-top:20px"><img id="Signature" src="<?php // $model->approvers['Signature'] ?>" width="128" height="100" border="1"/></div>
					<div><?= date("d/m/Y H:i:s",strtotime($model->ApprovalDate)); ?><div>
				</td>
			</tr>			
			</table>
			<?php
			$i = $key + 1;
			//echo $totalsuppliers.' '.$i; exit;
			if ($totalsuppliers != $i)
			{
				echo "<pagebreak />";
			}			
		} ?>

	</div>
</section>
