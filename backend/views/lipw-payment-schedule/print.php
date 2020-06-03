<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'label' => 'Beneficiary',
			'attribute' => 'lipwBeneficiaries.BeneficiaryName',
		],
		[
			'label' => 'Account Number',
			'attribute' => 'lipwBeneficiaries.BankAccountNumber',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Bank',
			'attribute' => 'lipwBeneficiaries.banks.BankName',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Branch',
			'attribute' => 'lipwBeneficiaries.bankBranches.BankBranchName',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label' => 'Days Worked',
			'attribute' => 'daysWorked',
			'headerOptions' => ['width' => '10%', 'style' => 'text-align: right'],
			'contentOptions' => ['style' => 'text-align: right'],
		],
		[
			'attribute' => 'Amount',
			'format' => ['decimal', 2],
			'headerOptions' => ['width' => '10%', 'style' => 'text-align: right; color: black'],
			'contentOptions' => ['style' => 'text-align: right'],
		],
		[
			'label' => 'Status',
			'attribute' => 'lipwPaymentScheduleStatus.PaymentScheduleStatusName',
			'format' => 'text',
			'headerOptions' => ['width' => '10%'],
		],
	],
]); ?>
