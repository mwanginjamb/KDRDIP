<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = $model->TaskName;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('tasks/index?pId=' . $model->ProjectID) . '", \'tab24\')']) ?>
	<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('tasks/update?id=' . $model->TaskID) . '", \'tab24\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('tasks/delete?id=' . $model->TaskID) . '", \'tab24\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'options' => [
		'class' => 'custom-table table-striped table-bordered zero-configuration',
	],
	'attributes' => [
		'TaskID',
		'TaskName',
		'taskMilestones.TaskMilestoneName',
		'Comments:ntext',		
		[
			'attribute' => 'StartDate',
			'format' => ['date', 'php:d/m/Y'],
		],
		[
			'attribute' => 'DueDate',
			'format' => ['date', 'php:d/m/Y'],
		],
		[
			'label' => 'Assigned To',
			'attribute' => 'assignedToUser.fullName',
		],
		[
			'label' => 'Status',
			'attribute' => 'taskStatus.TaskStatusName',
		],
		'CompletionPercentage',
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
