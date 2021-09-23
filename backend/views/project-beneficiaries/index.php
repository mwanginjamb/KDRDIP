<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Beneficiaries';
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
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-beneficiaries/create?pId=' . $pId) . '", \'tab6\')']) : '' ?>	
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
			'label'=>'County',
			'headerOptions' => ['style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'counties.CountyName',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label'=>'Sub County',
			'headerOptions' => ['width' => '30%', 'style'=>'color:black; text-align:left'],
			'format'=>'text',
			'value' => 'subCounties.SubCountyName',
			'contentOptions' => ['style' => 'text-align:left'],
		],
		[
			'label' => 'Host Male',
			'attribute' => 'HostPopulationMale',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format'=>'text',
		],
		[
			'label' => 'Host Female',
			'attribute'=>'HostPopulationFemale',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format'=>'text',
		],
		[
			'label' => 'Refugee Male',
			'attribute'=>'RefugeePopulationMale',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format'=>'text',
		],
		[
			'label' => 'Refugee Female',
			'attribute'=>'RefugeePopulationFemale',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
			'format'=>'text',
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Edit', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-beneficiaries/update?id=' . $model->ProjectBeneficiaryID) . '", \'tab6\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('project-beneficiaries/delete?id=' . $model->ProjectBeneficiaryID) . '", \'tab6\')',
					]) : '';
				},
			],
		],
	],
]); ?>
