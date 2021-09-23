<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = !empty($project) ? $project->ProjectName : '';
?>
<p>Project: <?=  $this->title ?></p>

<table class="pdf-table">
<thead>
	<tr>
		<th width="5%">ID</th>
		<th>Description of Service</th>
		<th width="5%">Unit</th>
		<th width="5%">Quantity</th>
		<th width="5%">Procurement Method</th>
		<th width="5%">Source of Funds</th>
		<th width="7%" align="right">Estimated Cost</th>
		<th width="7%" align="right">Actual Cost</th>
		<th width="10%">Time Process</th>
		<th width="5%">Invitation to bid/quote/ REoI</th>
		<th width="5%">Evaluation</th>
		<th width="5%">Notification of Award</th>
		<th width="5%">Contract Signing</th>
		<th width="5%">Inspection and Acceptance</th>
	</tr>
</thead>	
<tbody>
	<?php
	$activityId = 0;
	$activityTotal = 0;
	$grandTotal = 0;
	foreach ($procurementPlan as $key => $row) { 
		$lineId = $row->ProcurementPlanLineID;
		// $activityId = $row->ProcurementActivityID;
		?>
		<tr>
			<td rowspan="4"><?= $key+1; ?></td>
			<td rowspan="4"><?= $row->ServiceDescription; ?></td>
			<td rowspan="4"><?= $row->unitsOfMeasure->UnitOfMeasureName; ?></td>
			<td rowspan="4"><?= $row->Quantity; ?></td>
			<td rowspan="4"><?= $row->procurementMethods->ProcurementMethodName; ?></td>
			<td rowspan="4"><?= $row->SourcesOfFunds; ?></td>
			<td rowspan="4" align="right"><?= number_format($row['EstimatedCost'], 2); ?></td>
			<td rowspan="4" align="right"><?= number_format($row['ActualCost'], 2); ?></td>
			<td>Planned Dates</td>			
			<td><?= isset($activities[$lineId][1]) ? $activities[$lineId][1]['PlannedDate'] : '';?></td>		
			<td><?= isset($activities[$lineId][2]) ? $activities[$lineId][2]['PlannedDate'] : '';?></td>		
			<td><?= isset($activities[$lineId][3]) ? $activities[$lineId][3]['PlannedDate'] : '';?></td>		
			<td><?= isset($activities[$lineId][4]) ? $activities[$lineId][4]['PlannedDate'] : '';?></td>		
			<td><?= isset($activities[$lineId][5]) ? $activities[$lineId][5]['PlannedDate'] : '';?></td>	
		</tr>
		<tr>
			<td>Planned Days</td>
			<td><?= isset($activities[$lineId][1]) ? $activities[$lineId][1]['PlannedDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][2]) ? $activities[$lineId][2]['PlannedDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][3]) ? $activities[$lineId][3]['PlannedDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][4]) ? $activities[$lineId][4]['PlannedDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][5]) ? $activities[$lineId][5]['PlannedDays'] : '' ;?></td>
		</tr>
		<tr>
			<td>Actual Dates</td>
			<td><?= isset($activities[$lineId][1]) ? $activities[$lineId][1]['ActualStartDate'] : '' ;?></td>
			<td><?= isset($activities[$lineId][2]) ? $activities[$lineId][2]['ActualStartDate'] : '' ;?></td>
			<td><?= isset($activities[$lineId][3]) ? $activities[$lineId][3]['ActualStartDate'] : '' ;?></td>
			<td><?= isset($activities[$lineId][4]) ? $activities[$lineId][4]['ActualStartDate'] : '' ;?></td>
			<td><?= isset($activities[$lineId][5]) ? $activities[$lineId][5]['ActualStartDate'] : '' ;?></td>
		</tr>
		<tr>
			<td>Actual Days</td>
			<td><?= isset($activities[$lineId][1]) ? $activities[$lineId][1]['ActualDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][2]) ? $activities[$lineId][2]['ActualDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][3]) ? $activities[$lineId][3]['ActualDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][4]) ? $activities[$lineId][4]['ActualDays'] : '' ;?></td>
			<td><?= isset($activities[$lineId][5]) ? $activities[$lineId][5]['ActualDays'] : '' ;?></td>
		</tr>
		<?php
	} ?>
</tbody>
</table>
