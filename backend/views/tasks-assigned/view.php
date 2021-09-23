<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

$this->title = $this->title . ' ' . $model->TaskName;
$this->params['breadcrumbs'][] = $this->title;
$baseUrl = Yii::$app->request->baseUrl;

Modal::begin([
	'header' => '<h4 class="modal-title">Document</h4>',
	// 'footer' => Html::submitButton(Yii::t('app', 'Save')),
	'id' => 'pdf-viewer',
	'size' => 'modal-lg',
	]);

Modal::end();
?>

<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
					
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
						<div class="row">
							<div class="col-lg-5">
								<p>Enter Approval details below</p>
							<?php $form = ActiveForm::begin(); ?>
							<?= $form->field($notes, 'Notes')->textarea(['rows' => 3]) ?>
							<?php // $form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

							<div class="form-group">
								<?= (isset($rights->Edit)) ? Html::submitButton('<i class="ft-check"></i> Save', ['class' => 'btn btn-success mr-1', 'name'=>'Approve']) : ''; ?>
								<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning']) ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $detailmodel,
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

						<h4 class="form-section" style="margin-bottom: 0px">Notes</h4>
						<?= GridView::widget([
							'dataProvider' => $approvalNotesProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'showFooter' =>false,
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'Notes',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'Notes',
								],
								[
									'label'=>'Date',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format' => ['date', 'php:d/m/Y h:i a'],
									'value' => 'CreatedDate',
								],
								[
									'label'=>'Created By',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'users.fullName',
								],	
							],
						]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function() {

		$("#pdf-viewer").on("show.bs.modal", function(e) {
			var image = $(e.relatedTarget).data('image');
			var title = $(e.relatedTarget).data('title');
			$(".modal-body").html('<iframe src="'+  image +'" height="700px" width="100%"></iframe>');
			$(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">' + title + '</h4>');
		});
	});
</script>