<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

?>
<div style="width: 100%; display: block">
	<div style="width: 50%; float: left">
		<h2>Complaints List</h2>
	</div>
	<div style="width: 50%; float: right; text-align: right">
		<p>Printed By: <?= Yii::$app->user->identity->FirstName . ' ' . Yii::$app->user->identity->LastName; ?></p>
		<p>Printed On: <?= date('d M Y h:i a'); ?>
	</div>
</div>

<?php 
// print_r($arrayData); exit;
// foreach ($arrayData as $key => $dataProvider) {
// echo "$key </br>";
// }
// exit;
foreach ($arrayData as $key => $dataProvider) {
	$provider = new ArrayDataProvider([
		'allModels' => $dataProvider,
		'pagination' => false,
	]);
	echo GridView::widget([
		'dataProvider' => $provider,
		'showFooter' => false,
		'summary'=>'',
		'tableOptions' => [
			'class' => 'pdf-table table-striped table-bordered zero-configuration',
		],
		'columns' => [
			[
				'class' => 'yii\grid\SerialColumn',
				'headerOptions' => ['width' => '5%'],
			],
			[
				'value' => 'refNo',
				'label' => 'RefNo',
				'headerOptions' => ['width' => '10%'],
			],
			[
				'attribute' => 'complainantName',
				'label' => 'Customer',
			],
			[
				'attribute' => 'complaintMobile',
				'label' => 'Mobile',
				'headerOptions' => ['width' => '10%'],
			],
			[
				'label' => 'Complaint Type',
				'attribute' => 'complaintTypes.ComplaintTypeName',
				'headerOptions' => ['width' => '10%'],
			],
			[
				'attribute' => 'IncidentDate',
				'label' => 'Incident Date',
				'format' => ['date', 'php:d/m/Y'],
				'headerOptions' => ['width' => '10%'],
			],
			[
				'label' => 'Assigned To',
				'attribute' => 'assignedUser.fullName',
				'value' => function($model){
					return isset($model['assignedUser']) ? $model['assignedUser']['FirstName'] . ' ' . $model['assignedUser']['LastName'] : '';
				},
				'headerOptions' => ['width' => '10%'],
			],
			[
				'attribute' => 'complaintStatus.complaintStatusName',
				'headerOptions' => ['width' => '10%'],
				'label' => 'Status',
			],
			[
				'value' => 'CreatedDate',
				'label' => 'Created On',
				'format' => ['date', 'php:d/m/Y h:i a'],
				'headerOptions' => ['width' => '15%'],
			],
			[
				'label' => 'Created By',
				'attribute' => 'users.fullName',
				'value' => function($model){
					return isset($model['users']) ? $model['users']['FirstName'] . ' ' . $model['users']['LastName'] : '';
				},
				'headerOptions' => ['width' => '10%'],
			],
		],
	]);
} ?>