<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Component Finance Reports';

$totalBudgetedAmount = 0;
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
$totalAmountSpent = number_format($totalAmountSpent, 2);
?>
<p><?= $this->title; ?></p>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'tableOptions' => [
		'class' => 'pdf-table table-striped table-bordered',
	],
	'showFooter' => true,
	'summary'=>'',
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'label'=>'Component (A)',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'ComponentName',
			'contentOptions' => ['style' => 'text-align:left'],
			'footer' => 'Total',
			'footerOptions' => ['style' => 'font-weight:bold'],
		],
		[
			'label'=>'Approved Budget (B)',
			'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
			'format' => ['Decimal', 2],
			'value' => 'BudgetedAmount',
			'contentOptions' => ['style' => 'text-align:right'],
			'footer' => $totalBudgetedAmount,
			'footerOptions' => ['style' => 'font-weight:bold; text-align:right'],
		],
		[
			'label'=>'Actual Expenditure (C)',
			'format'=> ['Decimal', 2],
			'value' => 'AmountSpent',
			'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'footer' => $totalAmountSpent,
			'footerOptions' => ['style' => 'font-weight:bold; text-align:right'],
		],
		[
			'label'=>'Variance (D = B-C)',
			'format' => ['Decimal', 2],
			'value' => function ($model) {
				return $model['BudgetedAmount'] - $model['AmountSpent'];
			},
			'headerOptions' => ['width' => '17%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'footer' => $totalVariance,
			'footerOptions' => ['style' => 'font-weight:bold; text-align:right'],
		],
		[
			'label'=>'Remarks',
			'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:left'],
			'format' => 'text',
			'value' => function ($model) {
				return '';
			},
			'contentOptions' => ['style' => 'text-align:left'],
		],
	],
]); ?>
