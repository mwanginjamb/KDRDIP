<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LipwMasterRollRegister */

$this->title = $model->lipwBeneficiaries->BeneficiaryName;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Master Roll Registers', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-master-roll-register/index?mId=' . $model->MasterRollRegisterID) . '", \'tab2\')']) ?>
	<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-master-roll-register/update?id=' . $model->MasterRollRegisterID) . '", \'tab2\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->MasterRollRegisterID], [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('lipw-master-roll-register/delete?id=' . $model->MasterRollRegisterID) . '", \'tab2\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'options' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'attributes' => [
		'MasterRollRegisterID',
		[
			'attribute' => 'lipwBeneficiaries.BeneficiaryName',
			'label' => 'Beneficiary',
		],
		
		[
			'attribute' => 'Rate',
			'format' => ['decimal', 2],
		],
		[
			'attribute' => 'DateAdded',
			'format' => ['date', 'php:d/m/Y'],
		],
		[
			'attribute' => 'Active',
			'format' => 'boolean',
		],
		[
			'attribute' => 'CreatedDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
		],
		[
			'label' => 'Created By',
			'attribute' => 'users.fullName',
		],
	],
]) ?>
