<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lipw Beneficiaries';
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
<h4 class="form-section">Beneficiaries</h4>
<p>
	<?= Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/create?hId=' . $hId) . '", \'tab2\')']) ?>	
	<?= Html::a('<i class="fa fa-file-excel"></i> Excel Import', ['excel-import'], ['class' => 'btn btn-success mr-1'])?>
	<?= Html::a('<i class="fa fa-download"></i> Download Template', \yii\helpers\Url::home(true)."templates/community-groups.xlsx", ['class' => 'btn btn-info mr-1','title' => 'Get data import sample excel template here.'])?>	
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
			'contentOptions' => function ($model) {
				return ['style' => 'background-color:'
					 . ($model->Principal == '1' ? 'blue; color: white; ' : 'white')];
			},
		],
		'beneficiaryName',
		[
			'label' => 'Type',
			'attribute' => 'lipwBeneficiaryTypes.BeneficiaryTypeName',
			'format' => 'text',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'attribute' => 'IDNumber',
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'Age',
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Gender',
			'attribute' => 'Gender',
			'value' => function ($model) {
				return strtoupper($model['Gender']) == 'M' ? 'Male' : 'Female';
			},
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'Principal',
			'format' => 'boolean',
			'headerOptions' => ['width' => '5%'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) {
					return (1==1) ? Html::a('<i class="ft-edit"></i> Edit', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/update?id=' . $model->BeneficiaryID) . '", \'tab2\')']) : '';
				},
				'delete' => function ($url, $model)  {
					return (1 == 1) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/delete?id=' . $model->BeneficiaryID) . '", \'tab2\')',
					]) : '';
				},
			],
		],
	],
]); ?>



