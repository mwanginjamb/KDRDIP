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
<table class="custom-table table-striped table-bordered" style="border-color: black; border-collapse: collapse; width:50%" border="0">
<thead>
	<tr>
		<th>Status</th>
		<th align="right" width="20%">Number</th>
	</tr>
</thead>
<tbody>
	<?php 
	foreach ($statuses as $status) { ?>
		<tr>
			<td><?= $status['ProjectStatusName']; ?></td>
			<td align="right" style="background-color: <?= $status['ColorCode']; ?>"><?= number_format($status['Total'], 0); ?></td>
		</tr>
		<?php 
	}
	?>
</tbody>
</table>
<p></p>
<p>Projects Report - <?= $projectStatusName; ?></p>
	<?php
	$cID = 0;
	foreach ($projects as $key => $project) {
		if ($cID != $project->ComponentID) { 
			if ($cID != 0) { ?>
				</tbody>
				</table>
				<?php
			} ?>
			<h5 style="font-weight: bold"><?= $project->components->ComponentName; ?></h5>
			<table class="custom-table table-striped table-bordered" style="border-color: black; border-collapse: collapse; width:100%" border="0">
			<tbody>
			<tr>
				<th width="5%" style="color:black; text-align:center;">ID</th>
				<th style="color:black; text-align:left">Project</th>
				<th width="13%">Start Date</th>
				<th width="13%">End Date</th>
				<th width="13%">Status</th>
			</tr>
			<?php
			$cID = $project->ComponentID;
		}
		?>
		<tr>
			<td style="text-align:center"><?= $key + 1; ?></td>
			<td style="text-align:left"><?= $project['ProjectName']; ?></td>
			<td><?= date('d/m/Y', strtotime($project['StartDate'])); ?></td>
			<td><?= date('d/m/Y', strtotime($project['EndDate'])); ?></td>
			<td style="background-color: <?= $project['projectStatus']['ColorCode']; ?>"><?= $project['projectStatus']['ProjectStatusName'] ?></td>
		</tr>
		<?php
	} 
	
	if (count($projects) > 0 ) { ?>
		?>
		</tbody>
		</table>
		<?php
	} ?>
