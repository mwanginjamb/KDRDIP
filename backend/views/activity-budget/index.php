<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Budgets';
$this->params['breadcrumbs'][] = $this->title;

$Total = 0;
if (!empty($budgetProvider->getModels())) {
	foreach ($budgetProvider->getModels() as $key => $val) {
		//print_r($val);
		$Total += $val['Amount'];
	}
}
$Total = number_format($Total, 2);
?>

<?= GridView::widget([
	'dataProvider' => $budgetProvider,
	'layout' => '{items}',
	'showFooter' => true,
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered',
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
			'footerOptions' => ['style' => 'font-weight:bold; padding: 5px 15px'],
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
			'footerOptions' => ['style' => 'text-align:right; font-weight:bold; padding: 5px 15px'],
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
