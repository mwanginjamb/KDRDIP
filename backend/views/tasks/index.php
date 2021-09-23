<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
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
<p>
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('tasks/create?pId=' . $pId) . '", \'tab24\')']) : '' ?>	
</p>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'showFooter' =>false,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered',
	],
	'columns' => [

		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'label'=>'Description',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'TaskName',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label'=>'Milestone',
			'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'taskMilestones.TaskMilestoneName',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label' => 'Status',
			'attribute' => 'taskStatus.TaskStatusName',
			'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format'=>'text',
		],
		[
			'attribute' => 'StartDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'DueDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Assigned To',
			'attribute'=>'assignedToUser.fullName',
			'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format'=>'text',
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('tasks/view?id=' . $model->TaskID) . '", \'tab24\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('tasks/delete?id=' . $model->TaskID) . '", \'tab24\')',
					]) : '';
				},
			],
		],
	],
]); ?>