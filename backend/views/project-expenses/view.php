<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectExpenses */

$this->title = 'Expense ID: ' . $model->ProjectExpenseID;
$this->params['breadcrumbs'][] = ['label' => 'Project Expenses', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-expenses/index?pId=' . $model->ProjectID) . '", \'tab21\')']) ?>
	<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('project-expenses/update?id=' . $model->ProjectExpenseID) . '", \'tab21\')']) : '' ?>
	<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ProjectExpenseID], [
			'class' => 'btn-sm btn-danger',
			'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('project-expenses/delete?id=' . $model->ProjectExpenseID) . '", \'tab19\')',
	]) : '' ?>
</p>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'ProjectExpenseID',
		'expenseTypes.ExpenseTypeName',
		[
			'attribute' => 'Date',
			'format' => ['date', 'php:d/m/Y'],
		],		
		'Description:ntext',
		[
			'attribute' => 'Amount',
			'format' => ['decimal', 2],
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
