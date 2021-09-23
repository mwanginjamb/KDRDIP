<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lipw Payment Requests';
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
<h4 class="form-section">Payment Schedule / Payroll <span style="float: right"><a href="<?= Yii::$app->urlManager->createUrl('lipw-payment-schedule/print?pId=' . $pId);?>"><span class="material-icons">picture_as_pdf</span></a></span></h4>
<p style="color: red"><?= $message; ?></p>
<?php $form = ActiveForm::begin(['id' => 'currentForm']); ?>

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
				'headerOptions' => ['width' => '10%', 'style' => 'text-align: right'],
				'contentOptions' => ['style' => 'text-align: right'],
			],
			[
				'label' => 'Status',
				'attribute' => 'lipwPaymentScheduleStatus.PaymentScheduleStatusName',
				'format' => 'text',
				'headerOptions' => ['width' => '10%'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'headerOptions' => ['width' => '7%', 'style'=>'color:black; text-align:center'],
				'template' => '{view}',
				'header' => 'Paid',
				'buttons' => [
					'view' => function ($url, $model) use ($form) {
						return $form->field($model, '[' . $model->PaymentScheduleID . ']PaymentScheduleStatusID')->radioList([2 => 'Yes', 1 => 'No'], ['unselect' => null], ['item' => 'style="margin-bottom: 0px"']);
					},
				],
			],
		],
	]); ?>
	<div class="form-group">
		<?= Html::a('<i class="ft-x"></i> Reset', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-payment-schedule/schedule?pId=' . $pId) . '", \'tab3\')']) ?>
		<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl('lipw-payment-schedule/schedule?pId=' . $pId) . '",\'tab3\',\'currentForm\', \'saveBtn\')']) ?>
	</div>
<?php ActiveForm::end(); ?>
