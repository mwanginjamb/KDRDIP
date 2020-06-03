<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'pdf-table',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%'],
		],
		[
			'label' => 'Name',
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
