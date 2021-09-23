<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlan */

$this->title = $model->FinancialYear;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Plans', 'url' => ['index']];
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
	<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn-sm btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/index?pId=' . $model->ProjectID) . '", \'tab22\')']) ?>
	<?php	if ($model->ApprovalStatusID == 0) { ?>
		<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/update?id=' . $model->ProcurementPlanID) . '", \'tab22\')']) : '' ?>
		<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->ProcurementPlanID], [
				'class' => 'btn-sm btn-danger',
				'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('procurement-plan/delete?id=' . $model->ProcurementPlanID) . '", \'tab22\')',
		]) : '' ?>
		<?php 
		} elseif ($model->ApprovalStatusID == 3) { // if the PO has been approved ?>
			<?= Html::a('<i class="ft-printer"></i> Print', ['reports/procurement-plan', 'id' => $model->ProcurementPlanID], ['class' => 'btn-sm btn-warning mr-1 float-right']) ?>
			<?php 
		} if ($model->ApprovalStatusID == 0) { ?>
			<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Send for Approval', null, [
				'class' => 'btn-sm btn-danger',
				'onclick' => 'submitItem("' . Yii::$app->urlManager->createUrl('procurement-plan/submit?id=' . $model->ProcurementPlanID) . '", \'tab22\')',
			]) :'' ?>
		<?php
	} ?>	
</p>

<?= DetailView::widget([
	'model' => $model,
	'attributes' => [
		'ProcurementPlanID',
		'FinancialYear',
		'Comments:ntext',
		'approvalstatus.ApprovalStatusName',
		[
			'attribute' => 'ApprovalDate',
			'format' => ['date', 'php:d/m/Y h:i a'],
		],
		[
			'label' => 'Approved By',
			'attribute' => 'approvers.fullName',
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

<h4 class="form-section">Lines</h4>	 
<p>
	<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', null, ['class' => 'btn btn-primary mr-1', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/line-create?pId=' . $pId) . '", \'tab22\')']) : '' ?>	
</p>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'showFooter' =>false,
	'layout' => '{items}',
	'tableOptions' => [
		'class' => 'custom-table table-striped table-bordered',
	],
	'columns' => [
		[
			'class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
		],
		[
			'attribute' => 'ServiceDescription',
		],
		[
			'label' => 'Unit',
			'attribute' => 'unitsOfMeasure.UnitOfMeasureName',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label'=>'Quantity',
			'format'=> ['decimal', 2],
			'attribute' => 'Quantity',
			'headerOptions' => ['width' => '10%', 'style'=>'text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
		],
		[
			'attribute' => 'procurementMethods.ProcurementMethodName',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'attribute' => 'SourcesOfFunds',
			'headerOptions' => ['width' => '10%'],
		],
		[
			'label'=>'Estimated Cost',
			'format'=> ['decimal', 2],
			'attribute' => 'EstimatedCost',
			'headerOptions' => ['width' => '10%', 'style'=>'text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
		],
		[
			'label'=>'Actual Cost',
			'format'=> ['decimal', 2],
			'attribute' => 'actualExpenditure',
			'headerOptions' => ['width' => '10%', 'style'=>'text-align:right'],
			'contentOptions' => ['style' => 'text-align:right'],
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
			'template' => '{view} {remove}',
			'buttons' => [
				'view' => function ($url, $model) use ($rights) {
					return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/activities?id=' . $model->ProcurementPlanLineID) . '", \'tab22\')']) : '';
				},
				'remove' => function ($url, $model) use ($rights) {
					return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Remove', null, [
						'class' => 'btn-sm btn-danger btn-xs',
						'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('procurement-plan/remove-line?id=' . $model->ProcurementPlanLineID) . '", \'tab22\')',
					]) : '';
				},
			],
		],
	],
]); ?>
