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
	<?php
	$indID = 0;
	foreach ($activities as $key => $activity) {
		if ($indID != $activity['IndicatorID']) { ?>
			<tr>
				<td colspan="5">Indicator: <?= $activity['indicators']['IndicatorName']; ?></td>
			</tr>
			<tr>
				<th width="5%" style="color:black; text-align:center;">ID</th>
				<th>Activity</th>
				<th width="12%">Start Date</th>
				<th width="12%">End Date</th>
				<th width="20%">Responsibility</th>
			</tr>
			<?php
			$indID = $activity['IndicatorID'];
		}
		?>
		<tr>
			<td style="text-align:center"><?= $key + 1; ?></td>
			<td style="text-align:left"><?= $activity['ActivityName']; ?></td>
			<td><?= date('d/m/Y', strtotime($activity['StartDate'])); ?></td>
			<td><?= date('d/m/Y', strtotime($activity['EndDate'])); ?></td>
			<td><?= isset($activity['employees']) ? $activity['employees']['FirstName'] . ' ' . $activity['employees']['LastName'] : ''; ?></td>
		</tr>
		<?php
	} ?>
	</tbody>
</table>
