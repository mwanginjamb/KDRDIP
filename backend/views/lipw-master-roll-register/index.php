<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lipw Master Roll Registers';
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
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-master-roll-register/create?mId=' . $mId) . '", \'tab2\')']) : '' ?>	
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
		[
			'label' => 'Beneficiary',
			'attribute' => 'lipwBeneficiaries.BeneficiaryName',
		],
		[
			'label' => 'Household',
			'attribute' => 'lipwBeneficiaries.lipwHouseHolds.HouseholdName',
			'format' => 'text',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'label' => 'ID Number',
			'attribute' => 'lipwBeneficiaries.IDNumber',
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Age',
			'attribute' => 'lipwBeneficiaries.Age',
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'DateAdded',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'Rate',
			'format' => ['decimal', 2],
			'headerOptions' => ['width' => '10%', 'style' => 'text-align: right'],
			'contentOptions' => ['style' => 'text-align: right'],
		],
		// [
		// 	'attribute' => 'CreatedDate',
		// 	'format' => ['date', 'php:d/m/Y h:i a'],
		// 	'headerOptions' => ['width' => '15%'],
		// ],
		// [
		// 	'label' => 'Created By',
		// 	'attribute' => 'users.fullName',
		// 	'headerOptions' => ['width' => '15%'],
		// ],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {delete}',
			'buttons' => [

				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Edit', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-master-roll-register/update?id=' . $model->MasterRollRegisterID) . '", \'tab2\')']) : '';
				},
				'delete' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('lipw-master-roll-register/delete?id=' . $model->MasterRollRegisterID) . '", \'tab2\')',
					]) : '';
				},
			],
		],
	],
]); ?>
