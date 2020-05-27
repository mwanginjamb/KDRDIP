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
<table class="custom-table table-striped table-bordered" style="border-color: black; border-collapse: collapse; width: 100%" border="0">

	<tbody>
	<tr>
		<th width="5%" style="color:black; text-align:center;">ID</th>
		<th width="15%">Activity</th>
		<th width="15%">Sub Activity</th>
		<th>Indicator</th>
		<th width="15%">Output</th>
		<th width="10%">Start Date</th>
		<th width="10%">End Date</th>
		<!-- <th width="10%">Responsibility</th> -->
	</tr>
	<?php
	$indID = 0;
	foreach ($activities as $key => $activity) { ?>	
		<tr>		
			<td style="text-align:center"><?= $key + 1; ?></td>
			<td style="text-align:left"><?= $activity['ActivityName']; ?></td>
			<td style="text-align:left">
				<ul class="b">
				<?php foreach ($activity['activityBudget'] as $subActivity) { ?>
					<li><?=  $subActivity['Description']; ?></li>
					<?php
				}  ?>
				</ul>
			</td>
			<td><?= $activity['indicators']['IndicatorName']; ?></td>
			<td>
				<ul class="b">
				<?php foreach ($activity['activityOutputs'] as $output) { ?>
					<li><?=  $output['Output']; ?></li>
					<?php
				}  ?>
				</ul>
			</td>
			<td><?= date('d/m/Y', strtotime($activity['StartDate'])); ?></td>
			<td><?= date('d/m/Y', strtotime($activity['EndDate'])); ?></td>
			<!-- <td><?= isset($activity['employees']) ? $activity['employees']['FirstName'] . ' ' . $activity['employees']['LastName'] : ''; ?></td> -->
		</tr>
		<?php
	} ?>
	</tbody>
</table>
