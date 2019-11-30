<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

$this->title = 'View Requisition: '.$model->RequisitionID;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 6;
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
						<p>
						<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
						<?php if ($model->ApprovalStatusID == 0)
						{ ?>
							
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->RequisitionID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->RequisitionID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) ?>							
							<?php
						}
						?>
						
						<?php 
						if ($model->ApprovalStatusID == 0)
						{ ?>
							<?= Html::a('Send for Approval', ['submit', 'id' => $model->RequisitionID], [
								'class' => 'btn btn-danger', 'style' => 'width: 140px !important;margin-right: 5px;',
								'data' => [
											'confirm' => 'Are you sure you want to submit this item?',
											'method' => 'post',
										]
								]); ?>
							<?php
						}
						if ($model->ApprovalStatusID == 3)
						{ ?>
							<?= Html::a('<i class="ft-edit"></i> Create Quotation', ['create-quotation', 'id' => $model->RequisitionID], [
								'class' => 'btn btn-primary', 'style' => 'width: 140px !important;margin-right: 5px;',
								'data' => [
											'confirm' => 'Are you sure you want to Create a Quotation?',
											'method' => 'post',
										]
								]); ?>
							<?php
						}
						?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
									'RequisitionID',
									'CreatedDate',
								[
									'label'=>'Requested By',
									'attribute' => 'users.fullName',
								],          
									'Notes:ntext',
									'PostingDate',
									'approvalstatus.ApprovalStatusName',
							],
						]) ?>

						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'showFooter' =>false,
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
										return ($model->QuotationTypeID == 1 || $model->QuotationTypeID = '') ? $model->product->ProductName : $model->accounts->AccountName;
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
