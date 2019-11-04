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
								<?= Html::a('RFQ', ['rfq', 'id' => $model->QuotationID, 'returnlink' => 'view'], ['class' => 'btn btn-primary', 'style' => 'margin-bottom:10px']) ?>
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
							'attributes' => [
								'QuotationID',
								'Description',
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

						
						<div class="row">
							<div class="col-lg-6">
								<h4 class="form-section" style="margin-bottom: 0px">Products</h4>
								<?= GridView::widget([
									'dataProvider' => $dataProvider,
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
											'label'=>'Product Name',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'product.ProductName',
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
							</div>
							<div class="col-lg-6">
								<h4 class="form-section" style="margin-bottom: 0px">Suppliers</h4>
								<?= GridView::widget([
									'dataProvider' => $supplierProvider,
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
											'template' => '{view}',
											'buttons' => [

												'view' => function ($url, $model) use ($Rights, $FormID, $ApprovalStatusID){
													$baseUrl = Yii::$app->request->baseUrl;
													return ($ApprovalStatusID == 2) ? Html::a('<span class="fa fa-eye"></span> RFQ', $baseUrl.'/quotation/rfq?id='.$model->QuotationID.'&sid='.$model->SupplierID, [
																'title' => Yii::t('app', 'View'),
																'class'=>'gridbtn btn-primary btn-xs',                                  
																]) : '';
												},
											],
										],
									],
								]); ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
