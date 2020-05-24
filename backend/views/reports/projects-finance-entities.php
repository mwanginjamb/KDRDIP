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
<p>Projects Report - <?= !isset($projectStatusName) ? $projectStatusName : ''; ?></p>
<table class="custom-table table-striped table-bordered" style="border-color: black; border-collapse: collapse; width:100%" border="0"><thead>
<tr>
	<th width="5%" style="color:black; text-align:center;">ID</th>
	<th style="color:black; text-align:left">Entity</th>
	<th width="10%">Start Date</th>
	<th width="10%">End Date</th>
	<th width="13%" align="right">Budgeted Amount</th>
	<th width="13%" align="right">Disbursed Amount</th>
	<th width="13%" align="right">Amount Spent</th>
	<th width="10%">Status</th>
</tr>
</thead>
	<tbody>
	<?php
	foreach ($projects as $key => $project) {
		?>
		<tr>
			<td style="text-align:center"><?= $key + 1; ?></td>
			<td style="text-align:left"><?= $project['OrganizationName']; ?></td>
			<td><?= date('d/m/Y', strtotime($project['StartDate'])); ?></td>
			<td><?= date('d/m/Y', strtotime($project['EndDate'])); ?></td>
			<td align="right"><?= number_format($project->BudgetedAmount, 2); ?></td>
			<td align="right"><?= number_format($project->DisbursedAmount, 2); ?></td>
			<td align="right"><?= number_format($project->AmountSpent, 2); ?></td>
			<td><?= $project['projectStatus']['ProjectStatusName'] ?></td>
		</tr>
		<?php
	} ?>
	</tbody>
</table>
