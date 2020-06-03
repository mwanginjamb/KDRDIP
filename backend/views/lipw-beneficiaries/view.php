<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LipwBeneficiaries */

$this->title = $model->BeneficiaryID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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

.btn-warning {
	color: #FFFFFF !important;
}
</style>

<h4 class="form-section"><?= $this->title; ?></h4>
<p>
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/index?hId=' . $model->HouseholdID) . '", \'tab2\')']) ?>
	<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/update?id=' . $model->BeneficiaryID) . '", \'tab2\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->BeneficiaryID], [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('lipw-beneficiaries/delete?id=' . $model->BeneficiaryID) . '", \'tab2\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'BeneficiaryID',
		'FirstName',
		'MiddleName',
		'LastName',
		'IDNumber',
		'Mobile',
		'Gender',
		[
			'attribute' => 'DateOfBirth',
			'format' => ['date', 'php:d/m/Y'],
		],
		[
			'attribute' => 'Principal',
			'format' => 'boolean',
		],
		'AlternativeID',
		'BankAccountNumber',
		'BankAccountName',
		'banks.BankName',
		'banks.bankBranches.BankBranchName',
		'lipwBeneficiaryTypes.BeneficiaryTypeName',
		[
			'attribute' => 'createdTime',
			'format' => ['date', 'php:d/m/Y h:i a'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
		],
	],
]) ?>
