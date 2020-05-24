<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LipwWorkRegister */

$this->title = 'Work Register ID: ' . $model->WorkRegisterID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Work Registers', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-work-register/index?mId=' . $model->WorkRegisterID) . '", \'tab3\')']) ?>
	<?php // (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('lipw-work-register/update?id=' . $model->WorkRegisterID) . '", \'tab3\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->WorkRegisterID], [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('lipw-work-register/delete?id=' . $model->WorkRegisterID) . '", \'tab3\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'WorkRegisterID',
		[
			'attribute' => 'lipwBeneficiaries.BeneficiaryName',
			'label' => 'Beneficiary',
		],
		
		[
			'attribute' => 'Amount',
			'format' => ['decimal', 2],
		],
		[
			'attribute' => 'Date',
			'format' => ['date', 'php:d/m/Y'],
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
