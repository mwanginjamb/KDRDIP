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
		<th width="10%">Unit</th>
		<th width="10%">Quantity</th>
		<th width="10%">Procurement Method</th>
		<th width="10%">Source of Funds</th>
		<th width="10%" align="right">Estimated Cost</th>
		<th width="10%">Time Process</th>
	</tr>
</thead>	
<tbody>
	<?php
	$activityId = 0;
	$activityTotal = 0;
	$grandTotal = 0;
	foreach ($procurementPlan as $key => $row) { ?>
		<tr>
			<td rowspan="3"><?= $key+1; ?></td>
			<td rowspan="3"><?= $row->ServiceDescription; ?></td>
			<td rowspan="3"><?= $row->unitsOfMeasure->UnitOfMeasureName; ?></td>
			<td rowspan="3"><?= $row->Quantity; ?></td>
			<td rowspan="3"><?= $row->procurementMethods->ProcurementMethodName; ?></td>
			<td rowspan="3"><?= $row->SourcesOfFunds; ?></td>
			<td rowspan="3" align="right"><?= number_format($row['EstimatedCost'], 2); ?></td>
			<td>Planned Dates</td>			
		</tr>
		<tr>
			<td>Planned Days</td>
		</tr>
		<tr>
			<td>Actual Days</td>
		</tr>
		<?php
	} ?>
</tbody>
</table>
