<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Quotation */

$this->title = $model->Description;
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$ApprovalStatusID = $model->ApprovalStatusID;
$Rights = Yii::$app->params['rights'];
$FormID = 25;
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
							<?php	
							if ($model->ApprovalStatusID == 0) { ?>
								<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
								<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->QuotationID], ['class' => 'btn btn-primary']) ?>
								<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->QuotationID], [
										'class' => 'btn btn-danger',
										'data' => [
											'confirm' => 'Are you sure you want to delete this item?',
											'method' => 'post',
										],
								]) ?>
							<?php
							} elseif ($model->ApprovalStatusID == 3) // if the PO has been approved
							{ ?>
								<?= Html::a('<i class="ft-file"></i> RFQ', ['rfq', 'id' => $model->QuotationID, 'returnlink' => 'view'], ['class' => 'btn btn-primary']) ?>
								<?php
							}
							?>
							
							<?php if ($model->ApprovalStatusID == 0) { ?>
								<?= Html::a('<i class="ft-edit"></i> Send for Approval', ['submit', 'id' => $model->QuotationID], [
									'class' => 'btn btn-danger place-right', 'style' => 'width: 140px !important;margin-right: 5px;',
									'data' => [
												'confirm' => 'Are you sure you want to submit this item?',
												'method' => 'post',
											]
									]) ?>
								<?php
							}
							?>	
						</p>

						<?= DetailView::widget([
							'model' => $model,
							'options' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'attributes' => [
								'QuotationID',
								'Description',
								[
									'attribute' => 'requisition.Description',
									'label' => 'Requisition',
								],
								'CreatedDate',
								[
									'label'=>'Requested By',
									'attribute' => 'users.fullName',
								] ,
								'Notes:ntext',				
								'approvalstatus.ApprovalStatusName',
								'ApprovalDate',
							],
						]) ?>

						<h4 class="form-section" style="margin-bottom: 0px">Products</h4>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'showFooter' =>false,
							'columns' => [
								[
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'QuotationProductID',
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
										if ($model->QuotationTypeID == 1) {
											$result = $model->product->ProductName;
										} else {
											$result = isset($model->accounts->AccountName) ? $model->accounts->AccountName : '';
										}
										return $result;
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
							],
						]); ?>

						<h4 class="form-section" style="margin-bottom: 0px">Suppliers</h4>
						<?= GridView::widget([
							'dataProvider' => $supplierProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'showFooter' =>false,
							'columns' => [
								[
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'QuotationSupplierID',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Supplier',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'suppliers.SupplierName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
									'template' => '{response} {view}',
									'buttons' => [

										'response' => function ($url, $model) use ($Rights, $FormID, $ApprovalStatusID){
											$baseUrl = Yii::$app->request->baseUrl;
											return ($ApprovalStatusID == 3) ? Html::a('<i class="ft-eye"></i> Response', $baseUrl . '/quotation-response/create?qid=' . $model->QuotationID . '&sid='.$model->SupplierID, [
												'title' => Yii::t('app', 'View'),
												'class'=>'btn-sm btn-secondary btn-xs',
												]) : '';
										},

										'view' => function ($url, $model) use ($Rights, $FormID, $ApprovalStatusID){
											$baseUrl = Yii::$app->request->baseUrl;
											return ($ApprovalStatusID == 3) ? Html::a('<i class="ft-eye"></i> View RFQ', $baseUrl.'/quotation/rfq?id='.$model->QuotationID.'&sid='.$model->SupplierID, [
														'title' => Yii::t('app', 'View'),
														'class'=>'btn-sm btn-primary btn-xs',                                
														]) : '';
										},
									],
								],
							],
						]); ?>

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
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'ApprovalNoteID',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Notes',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'Note',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Date',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format' => ['date', 'php:d/m/Y h:i a'],
									'value' => 'CreatedDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Created By',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'users.fullName',
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
