<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaskMilestones */

$this->title = $model->TaskMilestoneName;
$this->params['breadcrumbs'][] = ['label' => 'Task Milestones', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('task-milestones/index?pId=' . $model->ProjectID) . '", \'tab23\')']) ?>
	<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('task-milestones/update?id=' . $model->TaskMilestoneID) . '", \'tab23\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('task-milestones/delete?id=' . $model->TaskMilestoneID) . '", \'tab23\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'options' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'attributes' => [
		'TaskMilestoneID',
		'TaskMilestoneName',
		'Notes:ntext',
		[
			'label' => 'Assigned To',
			'attribute' => 'users.fullName',
		],
		[
			'attribute' => 'StartDate',
			'format' => ['date', 'php:d/m/Y'],
		],
		[
			'attribute' => 'DueDate',
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
