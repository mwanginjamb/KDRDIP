<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
?>
<?= GridView::widget([
	'dataProvider' => $ordersProvider,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'columns' => [
		/* [
			'label'=>'ID',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
			'contentOptions' => ['style' => 'text-align:center'],
			'format'=>'text',
			'value' => 'PurchaseID',
			'contentOptions' => ['style' => 'text-align:left'],
		], */
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'label'=>'Date',
			'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
			'contentOptions' => ['style' => 'text-align:center'],
			'format'=>'date',
			'value' => 'CreatedDate',
			'contentOptions' => ['style' => 'text-align:left'],
		],				
		[
			'label'=>'Supplier Name',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'suppliers.SupplierName',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label'=>'Approval Status',
			'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'approvalstatus.ApprovalStatusName',
			'contentOptions' => ['style' => 'text-align:left'],
		],		
		[
			'label'=>'Posting Date',
			'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
			'format'=>'date',
			'value' => 'PostingDate',
			'contentOptions' => ['style' => 'text-align:left'],
		],	
	],
]); ?>
