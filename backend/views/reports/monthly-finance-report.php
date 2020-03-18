<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = !empty($project) ? $project->ProjectName : '';
/* $Total = 0;
if (!empty($dataProvider->getModels()))
{
	foreach ($dataProvider->getModels() as $key => $val) {
		//print_r($val);
		$Total += $val['Amount'];
	}
}
$Total = number_format($Total, 2); */
?>
<p>Sub-Project Title - <?= isset($projectData) ? $projectData->ProjectName : ''; ?></p>
<p>Component - <?= isset($projectData) ? $projectData->components->ComponentName : ''; ?></p>
<p>Reporting Period - <?= " $Month $Year"; ?></p>

<div class="space"></div>
<div class="company-name">RECEIPTS AND PAYMENT SCHEDULE</div>
<div class="space"></div>
<table class="pdf-table">
	<thead>
		<tr>
			<th colspan="3" style="text-align: center">RECEIPTS</th>
			<th colspan="3" style="text-align: center">PAYMENTS</th>
		</tr>
		<tr>
			<th width="10%">S/NO</th>	
			<th width="25%">PARTICULARS</th>	
			<th width="15%" class="number-column">KHS</th>
			<th width="10%">S/NO</th>	
			<th width="25%">PARTICULARS</th>		
			<th width="15%" class="number-column">KHS</th>
		</tr>
	</thead>
	<tbody>
		<tr>			
			<td></td>
			<td></td>
			<td class="number-column"><?= number_format(0, 2); ?></td>
			<td></td>
			<td></td>
			<td class="number-column"><?= number_format(0, 2); ?></td>
		</tr>
	</tbody>
</table>

<table width="100%" class="pdf-signoff-table">
	<tr>
		<td width="14%">Prepared By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
	<tr>
		<td width="14%">Checked By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
	<tr>
		<td width="14%">Approved By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
</table>

