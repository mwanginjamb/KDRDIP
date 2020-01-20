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
?>
<p>Project: <?=  $this->title ?></p>
<?= GridView::widget([
	'dataProvider' => $budgetProvider,
	'layout' => '{items}',
	'showFooter' => true,
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered',
		'style' => ' border-collapse: collapse; width: 100%'
	],
	'columns' => [
		/* [
			'attribute' => 'ActivityBudgetID',
			'label' => 'ID',
			'headerOptions' => ['style' => 'width:5% !important'],
		], */
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'attribute' => 'accounts.AccountName',
			'footer' => 'Total',
			'footerOptions' => ['style' => 'font-weight:bold; text-align: left'],
			// 'headerOptions' => ['style' => 'width:15% !important; '],
		],
		// [
		// 	'attribute' => 'Description',
		// 	'headerOptions' => [],
		// ],
		[
			'attribute' => 'Amount',
			'headerOptions' => ['style' => 'width:15% !important; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format' => ['decimal', 2],
			'footer' => $Total,
			'footerOptions' => ['style' => 'text-align:right; font-weight:bold;'],
		],
/* 		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['style' => 'width:17% !important'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
			'headerOptions' => ['style' => 'width:15% !important'],
		] */
	],
]); ?>