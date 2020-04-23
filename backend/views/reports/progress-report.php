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
<p>Project: <?= $this->title; ?></p>
<table class="custom-table table-striped table-bordered" style="font-size: 10px; border-color: black; border-collapse: collapse; width:100%" border="0"><thead>
<tr>
	<th width="5%" style="color:black; text-align:center;">ID</th>
	<th style="color:black; text-align:left">Indicator</th>
	<th>Unit Of Measure</th>
	<th>Base Line</th>
	<?php
	foreach ($reportingPeriods as $key => $period) { ?>
		<th><?= $period->ReportingPeriodName ;?> Target</th>
		<th><?= $period->ReportingPeriodName ;?> Actual</th>
	<?php } ?>
	<th>End Target</th>
	<th>Total Actual</th>
	<th>% of Target</th>
</tr>
</thead>
	<tbody>
	<?php
	foreach ($indicators as $key => $indicator) {
		$colNum = 7 + count($indicators);
		?>
		<tr>
			<td style="text-align:center"><?= $key + 1; ?></td>
			<td style="text-align:left"><?= $indicator['IndicatorName']; ?></td>
			<td><?= $indicator['unitsOfMeasure']['UnitOfMeasureName']; ?></td>
			<td align="right"><?= number_format($indicator['BaseLine'], 2); ?></td>
			<?php
			$totalActual = 0;
			foreach ($reportingPeriods as $key => $period) { 
				$totalActual += isset($actuals[$indicator['IndicatorID']][$period->ReportingPeriodID]) ? $actuals[$indicator['IndicatorID']][$period->ReportingPeriodID]['Actual'] : 0;
				?>
				<td align="right"><?= isset($targets[$indicator['IndicatorID']][$period->ReportingPeriodID]) ? $targets[$indicator['IndicatorID']][$period->ReportingPeriodID]['Target'] : ''; ?></td>
				<td align="right"><?= isset($actuals[$indicator['IndicatorID']][$period->ReportingPeriodID]) ? $actuals[$indicator['IndicatorID']][$period->ReportingPeriodID]['Actual'] : ''; ?></td>
			<?php } 
			$targetPer = $totalActual / $indicator['EndTarget'] * 100;
			?>
			<td align="right"><?= number_format($indicator['EndTarget'], 2); ?></td>
			<td align="right"><?= number_format($totalActual, 2); ?></td>
			<td align="right"><?= number_format($targetPer, 2); ?>%</td>
		</tr>
		<tr>
			<td colspan="<?= $colNum; ?>">Comments: <?= $indicator['Comments']; ?></td>
		</tr>
		<?php
	} ?>
	</tbody>
</table>
