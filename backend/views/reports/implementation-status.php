<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'KDRDIP Tool for Monitoring Implementation Status of the Approved Work Plans';


/* foreach ($dataProvider->getModels() as $key => $val) {
	print('<pre>');
	print_r($val->implementationStatus);
};
exit; */
?>
<p><?= $this->title; ?></p>

<table class="pdf-table table-striped table-bordered" border="0">
<thead>
	<tr>
		<th rowspan="2" width="5%">ID</th>
		<th rowspan="2" width="10%">Planned Activity – Sub-project</th>
		<th rowspan="2" width="5%">Planned output</th>
		<th rowspan="2" width="5%">Planned Start date</th>
		<th rowspan="2" width="5%">Planned End date</th>
		<th rowspan="2" align="right" width="5%">Approved budget (KES)</th>
		<th rowspan="2" align="right" width="5%">Actual Expenditures (KES)</th>
		<th rowspan="2" width="10%">Responsible CPMC</th>
		<th align="center" colspan="4">Implementation Status</th>
		<th rowspan="2" width="10%">Challenges</th>
		<th rowspan="2" width="10%">Agreed Corrective Action(s)</th>
		<th rowspan="2" width="10%">Responsible Person</th>
		<th rowspan="2" width="5%">Agreed date</th>
	</tr>
	<tr>
		<th align="center" width="2%">Q1</th>
		<th align="center" width="2%">Q2</th>
		<th align="center" width="2%">Q3</th>
		<th align="center" width="2%">Q4</th>
	</tr>
</thead>
<tbody>
	<?php
	foreach ($dataProvider->getModels() as $key => $val) { ?>
		<tr>
			<td><?= $val->ProjectID; ?></td>
			<td><?= $val->ProjectName; ?></td>
			<td><?= $val->Objective; ?></td>
			<td><?= date('d/m/Y', strtotime($val->StartDate)); ?></td>
			<td><?= date('d/m/Y', strtotime($val->EndDate)); ?></td>
			<td align="right"><?= number_format($val->BudgetedAmount, 2); ?></td>
			<td align="right"><?= number_format($val->AmountSpent, 2); ?></td>
			<td><?= isset($val->communities) ? $val->communities->CommunityName : ''; ?></td>
			<td style="background-color: <?= isset($val->implementationStatus[1]) ? $val->implementationStatus[1]['projectStatus']['ColorCode'] : ''; ?>"></td>
			<td style="background-color: <?= isset($val->implementationStatus[2]) ? $val->implementationStatus[2]['projectStatus']['ColorCode'] : ''; ?>"></td>
			<td style="background-color: <?= isset($val->implementationStatus[3]) ? $val->implementationStatus[3]['projectStatus']['ColorCode'] : ''; ?>"></td>
			<td style="background-color: <?= isset($val->implementationStatus[4]) ? $val->implementationStatus[4]['projectStatus']['ColorCode'] : ''; ?>"></td>
			<td><?= isset($val->majorChallenge) ? $val->majorChallenge->Challenge : ''; ?></td>
			<td><?= isset($val->majorChallenge) ? $val->majorChallenge->CorrectiveAction : ''; ?></td>
			<td><?= isset($val->majorChallenge) ? $val->majorChallenge->employees->EmployeeName : ''; ?></td>
			<td><?= isset($val->majorChallenge) ? date('d/m/Y', strtotime($val->majorChallenge->AgreedDate)) : ''; ?></td>
		</tr>
		<?php
	}
	?>
</tbody>
</table>


<table width="100%">
<tr>
	<td style="height:30px"></td>
</tr>
<tr>
	<td>Compiled by: _______________________________________________ </td>
	<td width="35%">Signature: __________________________</td>
	<td width="15%">Date: ______________</td>
</tr>
<tr>
	<td style="height:30px"></td>
</tr>
<tr>
	<td>Signed Off by: ______________________________________________ </td>
	<td>Signature: __________________________</td>
	<td>Date: ______________</td>
</tr>
<tr>
	<td style="height:30px"></td>
</tr>
</table>

<table class="pdf-key-table">
<thead>
	<tr>
		<th colspan="3">Legend for implementation status column</th>
	</tr>
	<tr>
		<th width="10%">Color</th>
		<th width="10%">Status</th>
		<th>Explanation</th>
	</tr>
</thead>
<tbody>
	<?php
	foreach ($statusProvider->getModels() as $key => $val) { ?>
		<tr>
			<td style="background-color: <?= $val->ColorCode; ?>"></td>
			<td><?= $val->ProjectStatusName; ?></td>
			<td><?= $val->Notes; ?></td>
		</tr>
		<?php
	}
	?>
</tbody>
</table>