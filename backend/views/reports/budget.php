<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = !empty($project) ? $project->ProjectName : '';
$Total = 0;
if (!empty($budgetProvider->getModels())) {
	foreach ($budgetProvider->getModels() as $key => $val) {
		//print_r($val);
		$Total += $val['Amount'];
	}
}
$Total = number_format($Total, 2);
$model = $budgetProvider->getModels();
?>
<p>Project: <?=  $this->title ?></p>

<table class="pdf-table">
<thead>
	<tr>
		<th width="5%">ID</th>
		<th>Sub Activity</th>
		<th width="15%" align="right">Amount</th>
	</tr>
</thead>	
<tbody>
	<?php
	$activityId = 0;
	$activityTotal = 0;
	$grandTotal = 0;
	foreach ($model as $key => $row) {
		if (isset($row['activities']) && $activityId != $row['activities']['ActivityID']) {
			if ($activityId != 0) { ?>
				<tr>
					<th colspan="2" align="left">Activity Total</th>
					<th align="right"><?= number_format($activityTotal, 2); ?></th>
				</tr>
				<?php
			}	?>
			<tr>
				<td colspan="3">Activity: <?= $row['activities']['ActivityName']; ?></td>
			</tr>
			<?php
			$activityId = $row['activities']['ActivityID'];
			$activityTotal = 0;
		} ?>
		<tr>
			<td><?= $key+1; ?></td>
			<td><?= $row['Description']; ?></td>
			<td align="right"><?= number_format($row['Amount'], 2); ?></td>
		</tr>
		<?php
		$activityTotal += $row['Amount'];
		$grandTotal += $row['Amount'];
	} ?>
	<tr>
		<th colspan="2" align="left">Activity Total</th>
		<th align="right"><?= number_format($activityTotal, 2); ?></th>
	</tr>
	<tr>
		<th colspan="2" align="left">Grand Total</th>
		<th align="right"><?= number_format($grandTotal, 2); ?></th>
	</tr>
</tbody>
</table>
