<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Milestones';
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
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('task-milestones/create?pId=' . $pId) . '", \'tab23\')']) : '' ?>	
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
			'label' => 'Milestone',
			'attribute' => 'TaskMilestoneName',
			'headerOptions' => ['style'=>'color:black;'],
			'format'=>'text',
		],
		[
			'attribute' => 'StartDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'DueDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '15%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->Edit)) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('task-milestones/view?id=' . $model->TaskMilestoneID) . '", \'tab23\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('task-milestones/delete?id=' . $model->TaskMilestoneID) . '", \'tab23\')',
					]) : '';
				},
			],
		],
	],
]); ?>
