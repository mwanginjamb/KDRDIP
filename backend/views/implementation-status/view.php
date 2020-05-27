<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ImplementationStatus */

$this->title = $model->ImplementationStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Implementation Statuses', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('implementation-status/index?pId=' . $model->ProjectID) . '", \'tab18\')']) ?>
	<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('implementation-status/update?id=' . $model->ImplementationStatusID) . '", \'tab18\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ImplementationStatusID], [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('implementation-status/delete?id=' . $model->ImplementationStatusID) . '", \'tab18\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'ImplementationStatusID',
		'projectStatus.ProjectStatusName',
		[
			'attribute' => 'Date',
			'format' => ['date', 'php:d/m/Y'],
		],
		'Notes',
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
