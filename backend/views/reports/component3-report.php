<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Component 1 Finance Reports';

/* $totalBudgetedAmount = 0;
$totalAmountSpent = 0;
$totalVariance = 0;
if (!empty($dataProvider->getModels())) {
	foreach ($dataProvider->getModels() as $key => $val) {
		$totalBudgetedAmount += $val->BudgetedAmount;
		$totalAmountSpent += $val->AmountSpent;
	}
}
$totalVariance = number_format($totalBudgetedAmount - $totalAmountSpent, 2);
$totalBudgetedAmount = number_format($totalBudgetedAmount, 2);
$totalAmountSpent = number_format($totalAmountSpent, 2); */
?>
<p><?= $component->ComponentName; ?></p>

<table class="pdf-table table-striped table-bordered">
<thead>
	<tr role="row">
		<th width="5%" align="center">#</th>
		<th>Types</th>
		<th width="17%" align="right">Budget</th>
		<th width="17%" align="right">Actual Expenditure</th>
		<th width="17%" align="right">Variance</th>				
	</tr>
</thead>
<tbody>
	<?php
	foreach ($subComponents as $subComponent) { ?>
		<tr>
			<td colspan="5"><?= $subComponent->SubComponentName; ?></td>
		<tr>
		<?php 
		foreach ($enterpriseTypes as $i => $enterpriseType) {
			$budgetAmount = isset($budget[$subComponent->SubComponentID][$enterpriseType->EnterpriseTypeID]) ? $budget[$subComponent->SubComponentID][$enterpriseType->EnterpriseTypeID]['BudgetAmount'] : 0;
			$amountSpent = isset($expenditure[$subComponent->SubComponentID][$enterpriseType->EnterpriseTypeID]) ? $expenditure[$subComponent->SubComponentID][$enterpriseType->EnterpriseTypeID]['AmountSpent'] : 0;
			?>
			<tr>
				<td align="center"><?= $i + 1; ?></td>
				<td><?= $enterpriseType->EnterpriseTypeName; ?></td>
				<td align="right"><?= number_format($budgetAmount, 2); ?></td>
				<td align="right"><?= number_format($amountSpent, 2); ?></td>
				<td align="right"><?= number_format($budgetAmount - $amountSpent, 2); ?></td>
			<tr>
			<?php
		}
	} ?>
</tbody>
</table>
