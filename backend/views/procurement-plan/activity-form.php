<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;

$url = Url::home(true);
$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\ProcurementPlan */
/* @var $form yii\widgets\ActiveForm */
$this->title = $model->procurementActivities->ProcurementActivityName;
?>
<style>
#ParameterTable .form-group {
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	/* */
}
</style>
<div class="card">
	<div class="card-header">
		<h4 class="form-section"><?= $this->title; ?></h4>
		
		<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
				<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
				<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
			</ul>
		</div>
	</div>
	<div class="card-content collapse show">
		<div class="card-body">
			<?php $form = ActiveForm::begin(['id' => 'currentForm', 'enableAjaxValidation' => true]); ?>
	 
				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'PlannedDate')->textInput(['maxlength' => true, 'type' => 'date']) ?>
					</div>
					<div class="col-md-6">		
						<?= $form->field($model, 'PlannedDays')->textInput(['maxlength' => true, 'type' => 'number']) ?>			
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'ActualStartDate')->textInput(['maxlength' => true, 'type' => 'date']) ?>
					</div>
					<div class="col-md-6">		
						<?= $form->field($model, 'ActualClosingDate')->textInput(['maxlength' => true, 'type' => 'date']) ?>			
					</div>			
				</div>

				<div class="row">
					<div class="col-md-6">
						<?= $form->field($model, 'Comments')->textarea(['rows' => 2]) ?>
					</div>
					<div class="col-md-6">	
						<?= $form->field($model, 'imageFile')->fileInput() ?>
					</div>			
				</div>	

				<div class="form-group">
					<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('procurement-plan/activities?id=' . $model->ProcurementPlanLineID) . '", \'tab22\')']) ?>
					<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'style' => 'color: white', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl('procurement-plan/activity-update?id=' . $model->ProcurementActivityLineID) . '",\'tab22\',\'currentForm\', \'saveBtn\')']) ?>
				</div>

			<?php ActiveForm::end(); ?>
			<h4 class="form-section">Documents</h4>	
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
						'label'=>'Description',
						'headerOptions' => ['style'=>'color:black; text-align:left'],
						'format'=>'text',
						'value' => 'Description',
						'contentOptions' => ['style' => 'text-align:left'],
					],
					[
						'label' => 'Document Type',
						'attribute' => 'documentTypes.DocumentTypeName',
						'headerOptions' => ['width' => '15%'],
					],
					[
						'attribute' => 'CreatedDate',
						'format' => ['date', 'php:d/m/Y h:i a'],
						'headerOptions' => ['width' => '15%'],
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
						'template' => '{photo} {delete}',
						'buttons' => [
							'photo' => function($url, $model) use ($baseUrl) {								
								return '<a href="#pdf-viewer" data-toggle="modal" data-image="' . $model->Image . '" data-title="document"><img src="' . $baseUrl . '\images\pdf-icon.png" height="30" width="auto"></a>';
							},
							'view' => function ($url, $model) use ($rights) {
								return (isset($rights->View)) ? Html::a('<i class="ft-edit"></i> View', null, ['class' => 'btn-sm btn-primary', 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('documents/view?id=' . $model->DocumentID) . '", \'tab15\')']) : '';
							},
							'delete' => function ($url, $model) use ($rights) {
								return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', null, [
									'class' => 'btn-sm btn-danger btn-xs',
									'onclick' => 'deleteItem("' . Yii::$app->urlManager->createUrl('documents/delete?id=' . $model->DocumentID) . '", \'tab15\')',
								]) : '';
							},
						],
					],
				],
			]); ?>

		</div>
	</div>
</div>
