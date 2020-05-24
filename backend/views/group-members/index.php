<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Group Members';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-actions1" style="margin-top:0px">
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', ['/group-members/create', 'gid' => $model->CommunityGroupID], ['class' => 'btn btn-primary mr-1']) : '' ?>
</div>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		'MemberName',
		'Gender',
		'groupRoles.GroupRoleName',
		[
			'attribute' => 'DateOfBirth',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
			'headerOptions' => ['width' => '15%'],
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
					return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['/group-members/view', 'id' => $model->CommunityGroupMemberID], ['class' => 'btn-sm btn-primary']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['/group-members/delete', 'id' => $model->CommunityGroupMemberID], [
						'class' => 'btn-sm btn-danger btn-xs',
						'data' => [
							'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
							'method' => 'post',
						],
					]) : '';
				},
			],
		],
	],
]); ?>
