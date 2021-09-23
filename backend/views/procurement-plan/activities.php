<?php

use yii\helpers\Html;
use yii\grid\GridView;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.btn-primary {
	border-color: #512E90 !important;
	background-color: #6BA342 !important;
	color: #FFFFFF !important;
}

.btn-danger {
	color: #FFFFFF !important;
}
</style>
<h4 class="form-section"><?= $this->title; ?></h4>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%'],
		],
		'procurementActivities.ProcurementActivityName',
		[
			'attribute' => 'PlannedDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '17%'],
		],
		'PlannedDays',
		[
			'attribute' => 'ActualStartDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '17%'],
		],
		[
			'attribute' => 'ActualClosingDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '17%'],
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '17%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
			'template' => '{view}',
			'buttons' => [
				'photo' => function($url, $model) use ($baseUrl, $procurementPlanLine) {
					if ($model->image != '') {
						return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
					}
				},
				'view' => function ($url, $model) use ($rights, $procurementPlanLine) {
					return (isset($rights->View) && $procurementPlanLine->procurementPlan->ApprovalStatusID == 3) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/activity-update?id=' . $model->ProcurementActivityLineID) . '", \'tab22\')']) : '';
				},
			],
		],
	],
]); ?>
