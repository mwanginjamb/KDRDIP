<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Challenges';
$this->params['breadcrumbs'][] = $this->title;
// if (!empty($majorChallenge->getModels())) {
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
<h4 class="form-section">Major Challenge</h4>
<p>
	<?= (isset($rights->Create) && empty($majorChallenge->getModels())) ? Html::a('<i class="ft-plus"></i> Add Major Challenge', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-challenges/create?major=1&pId=' . $pId . '&typeId=' . $typeId) . '", \'tab19\')']) : '' ?>	
</p>
<?= GridView::widget([
	'dataProvider' => $majorChallenge,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%'],
		],
		'Challenge',
		[
			'attribute' => 'AgreedDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Assiged To',
			'attribute' => 'employees.EmployeeName',
			'format' => 'text',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '17%'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-challenges/view?id=' . $model->ProjectChallengeID) . '", \'tab19\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('project-challenges/delete?id=' . $model->ProjectChallengeID) . '", \'tab19\')',
					]) : '';
				},
			],
		],
	],
]); ?>

<h4 class="form-section"><?= $this->title; ?></h4>
<p>
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-challenges/create?major=0&pId=' . $pId . '&typeId=' . $typeId) . '", \'tab19\')']) : '' ?>	
</p>
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
		'Challenge',
		[
			'attribute' => 'AgreedDate',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Assiged To',
			'attribute' => 'employees.EmployeeName',
			'format' => 'text',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '17%'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-challenges/view?id=' . $model->ProjectChallengeID) . '", \'tab19\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('project-challenges/delete?id=' . $model->ProjectChallengeID) . '", \'tab19\')',
					]) : '';
				},
			],
		],
	],
]); ?>
