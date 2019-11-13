<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

$this->title = 'View Requisition: '.$model->StoreRequisitionID;
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
								<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
								<?= Html::submitButton('<i class="ft-check"></i> Approve', ['class' => 'btn btn-success', 'name'=>'Approve']);?>
								<?= Html::submitButton('<i class="ft-x"></i> Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']); ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $detailmodel,
							'attributes' => [
									'StoreRequisitionID',
									'CreatedDate',
									'CreatedBy',
									'Notes:ntext',
									'PostingDate',
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
								'label'=>'ID',
								'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								'contentOptions' => ['style' => 'text-align:center'],
								'format'=>'text',
								'value' => 'RequisitionLineID',
								'contentOptions' => ['style' => 'text-align:left'],
							],				
							[
								'label'=>'Product Name',
								'headerOptions' => ['style'=>'color:black; text-align:left'],
								'format'=>'text',
								'value' => 'product.ProductName',
								'contentOptions' => ['style' => 'text-align:left'],
								'footer' => 'Total',
								'footerOptions' => ['style' => 'font-weight:bold'],
							],
							[
								'label'=>'Quantity',
								'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
								'format'=>['decimal',2],
								'value' => 'Quantity',
								'contentOptions' => ['style' => 'text-align:right'],
							],		
							[
								'label'=>'Description',
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
