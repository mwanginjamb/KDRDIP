<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lipw Payment Request Lines';
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
			'attribute' => 'lipwWorkRegister.lipwBeneficiaries.BeneficiaryName',
		],
		[
			'label' => 'Household',
			'attribute' => 'lipwWorkRegister.lipwBeneficiaries.lipwHouseHolds.HouseholdName',
		],
		[
			'label' => 'Gender',
			'attribute' => 'lipwWorkRegister.lipwBeneficiaries.Gender',
		],
		[
			'label' => 'Age',
			'attribute' => 'lipwWorkRegister.lipwBeneficiaries.Age',
		],
		[
			'label' => 'ID Number',
			'attribute' => 'lipwWorkRegister.lipwBeneficiaries.IDNumber',
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Sub Project',
			'attribute' => 'lipwWorkRegister.projects.ProjectName',
			'headerOptions' => ['width' => '15%'],
		],
		[
			'label' => 'Work Date',
			'attribute' => 'lipwWorkRegister.Date',
			'format' => ['date', 'php:d/m/Y'],
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'Amount',
			'format' => ['decimal', 2],
			'headerOptions' => ['width' => '10%', 'style' => 'text-align: right'],
			'contentOptions' => ['style' => 'text-align: right'],
		],
	],
]); ?>
