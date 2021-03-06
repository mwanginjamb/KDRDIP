<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

// $this->title = 'View Requisition: '.$model->RequisitionID;
switch ($model->ApprovalStatusID) {
	case 1:
		$this->title = 'Requisition Review:';
		break;
	case 2:
		$this->title = 'Requisition Approvals:';
		break;
	case 3:
		$this->title = 'Requisition Approved:';
		break;
	case 4:
		$this->title = 'Requisition Rejected:';
		break;
	default:
		$this->title = 'Requisition Review:';
}
$this->title = $this->title . ' ' . $model->RequisitionID;

$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 12;
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
							<?= $form->field($notes, 'Note')->textarea(['rows' => 3]) ?>
							<input type="hidden" id="option" name="option" value="<?= $option; ?>">
							<?php // $form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

							<div class="form-group">
								<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
								<?= Html::submitButton('<i class="ft-check"></i> Approve', ['class' => 'btn btn-success', 'name'=>'Approve']);?>
								<?= Html::submitButton('<i class="ft-x"></i> Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']); ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $detailmodel,
							'attributes' => [
									'RequisitionID',
									'projects.counties.CountyName',
									'projects.subCounties.SubCountyName',
									'projects.wards.WardName',
									'projects.ProjectName',
									[
										'attribute' => 'CreatedDate',
										'format' => ['date', 'php:d/m/Y h:i a'],
										
									],
									[
										'label'=>'Requested By',
										'attribute' => 'users.fullName',
									],  
									'Notes:ntext',
									[
										'attribute' => 'PostingDate',
										'format' => ['date', 'php:d/m/Y'],
										
									],
									'approvalstatus.ApprovalStatusName',
							],
						]) ?>

						<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'showFooter' =>false,
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
								'label'=>'Type',
								'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:left'],
								'format'=>'text',
								'value' => 'quotationTypes.QuotationTypeName',
								'contentOptions' => ['style' => 'text-align:left'],
							],
							[
								'label'=>'Description',
								'headerOptions' => ['style'=>'color:black; text-align:left'],
								'format'=>'text',
								'value' => function ($model) {
									if ($model->QuotationTypeID == 1) {
										return isset($model->product->ProductName) ? $model->product->ProductName : '';
									} else {
										return isset($model->accounts->AccountName) ? $model->accounts->AccountName : '';
									}
									// return ($model->QuotationTypeID == 1) ? $model->product->ProductName : $model->accounts->AccountName;
								},
								'contentOptions' => ['style' => 'text-align:left'],
							],
							[
								'label'=>'Quantity',
								'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
								'format'=>['decimal',2],
								'value' => 'Quantity',
								'contentOptions' => ['style' => 'text-align:right'],
							],
							[
								'label'=>'Comments',
								'headerOptions' => ['width' => '45%','style'=>'color:black; text-align:left'],
								'format'=>'text',
								'value' => 'Description',
								'contentOptions' => ['style' => 'text-align:left'],
							],		
						],
					]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
