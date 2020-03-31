<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = !empty($project) ? $project->ProjectName : '';
?>
<div class="space"></div>
<table width="100%" class="pdf-signoff-table1">
	<tr>
		<td>Sub-Project Title - <?= isset($projectData) ? $projectData->ProjectName : ''; ?></td>
	</tr>
	<tr>
		<td>Component - <?= isset($projectData) ? $projectData->components->ComponentName : ''; ?></td>
	</tr>
	<tr>
		<td>Reporting Period - <?= " $Month $Year"; ?></td>
	</tr>
</table>
<div class="space"></div>
<div class="space"></div>

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
		<?php
			$count = (count($fundsRequisition) > count($payments)) ? count($fundsRequisition) : count($payments);
			for ($i = 0; $i < $count; $i++) {
				?>
				<tr>			
					<td><?= isset($fundsRequisition[$i]) ? $fundsRequisition[$i]->FundRequisitionID : ''; ?></td>
					<td><?= isset($fundsRequisition[$i]) ? $fundsRequisition[$i]->Description : ''; ?></td>
					<td class="number-column"><?= isset($fundsRequisition[$i]) ? number_format($fundsRequisition[$i]->FundRequisitionID, 2) : ''; ?></td>
					<td><?= isset($payments[$i]) ? $payments[$i]->PaymentID : ''; ?></td>
					<td><?= isset($payments[$i]) ? $payments[$i]->Description : ''; ?></td>
					<td class="number-column"><?= isset($payments[$i]) ? number_format($payments[$i]->Amount, 2) : ''; ?></td>
				</tr>
				<?php
			} ?>
	</tbody>
</table>
<div class="space"></div>
<table width="100%" class="pdf-signoff-table1">
	<tr>
		<td width="25%">Total Receipts (Kshs)</td>
		<td width="15%" align="right"><?= number_format($totalReceipts, 2); ?></td>
		<td></td>
	</tr>
	<tr>
		<td width="25%">Total Payments (Kshs)</td>
		<td width="15%" align="right"><?= number_format($totalPayments, 2); ?></td>
		<td></td>
	</tr>
	<tr>
		<td width="25%">Closing Balance (Kshs)</td>
		<td width="15%" align="right"><?= number_format($totalReceipts - $totalPayments, 2); ?></td>
		<td></td>
	</tr>
</table>
<div class="space"></div>
<div class="space"></div>

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

