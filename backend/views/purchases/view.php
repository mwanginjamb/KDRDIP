<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Purchases */

$this->title = 'View Purchase :'.$model->PurchaseID;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 5;

$Total = 0;
if (!empty($dataProvider->getModels())) 
{
	foreach ($dataProvider->getModels() as $key => $val) 
	{
		$Total += $val->Unit_Total;
    }
}
$Total = number_format($Total,2);
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
						<p></p>
						<?php if ($model->ApprovalStatusID == 0 || $model->ApprovalStatusID == 5)
						{ ?>
							<?= Html::a('<i class="ft-edit"></i> Edit', ['update', 'id' => $model->PurchaseID], ['class' => 'btn btn-primary']); ?>
							
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->PurchaseID], [
								'class' => 'btn btn-danger',
								'data' => [
									'confirm' => 'Are you sure you want to delete this item?',
									'method' => 'post',
								],
							]); ?>
							
							
							<?php
						} else if ($model->ApprovalStatusID == 3 ) // if the PO has been approved
						{ ?>
						
							<?= Html::a('Pur. Order', ['purchaseorder', 'id' => $model->PurchaseID, 'returnlink' => 'view'], ['class' => 'btn btn-primary']) ?>
							<?= ($model->Closed == 0) ? Html::a('<i class="ft-edit"></i> Close Pur.', ['close', 'id' => $model->PurchaseID], [
								'class' => 'btn btn-danger',
								'data' => [
									'confirm' => 'Are you sure you want to close this item?',
									'method' => 'post',
								],
							]) : ''; ?>
							<?php
						}
						?>
						<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
						
						<?php if ($model->ApprovalStatusID == 0 || $model->ApprovalStatusID == 5)
						{ ?>
							<?= Html::a('Send for Approval', ['submit', 'id' => $model->PurchaseID], [
								'class' => 'btn btn-danger place-right', 'style' => 'width: 140px !important;margin-right: 5px;',
								'data' => [
											'confirm' => 'Are you sure you want to submit this item?',
											'method' => 'post',
										]
								]); ?>
							<?php
						}
						?>	
						<p></p>
								<?= DetailView::widget([
									'model' => $model,
									'options' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration',
									],
									'attributes' => [
										'PurchaseID',
										'suppliers.SupplierName',				
										'CreatedDate',
										[
											'label'=>'Requested By',
											'attribute' => 'users.fullName',
										] ,
										'Notes:ntext',
										'Postedstring',
										'PostingDate',
										'approvalstatus.ApprovalStatusName',
										'ClosedString',
									],
								]) ?>
								
								<?= GridView::widget([
									'dataProvider' => $dataProvider,
									'tableOptions' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration',
									],
									'showFooter' =>true,
									'columns' => [
										[
											'label'=>'ID',
											'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
											'contentOptions' => ['style' => 'text-align:center'],
											'format'=>'text',
											'value' => 'PurchaseLineID',
											'contentOptions' => ['style' => 'text-align:left'],
										],		
										[
											'label'=>'Supplier Code',
											'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'SupplierCode',
											'contentOptions' => ['style' => 'text-align:left'],
										],				
										[
											'label'=>'Product Name',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'product.ProductName',
											'contentOptions' => ['style' => 'text-align:left'],
											'footer' => 'Total',
											'footerOptions' => ['style' => 'font-weight:bold; padding: 10px 15px'],
										],
										[
											'label'=>'Quantity',
											'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
											'format'=>['decimal',2],
											'value' => 'Quantity',
											'contentOptions' => ['style' => 'text-align:right'],
										],	
										[
											'label'=>'Usage Unit',
											'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'usageunit.UsageUnitName',
											'contentOptions' => ['style' => 'text-align:left'],
										],				
										[
											'label'=>'Unit Price',
											'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
											'format'=>['decimal',2],
											'value' => 'UnitPrice',
											'contentOptions' => ['style' => 'text-align:right'],
										],	
										[
											'label'=>'Total',
											'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
											'format'=>['decimal',2],
											'value' => 'Unit_Total',
											'contentOptions' => ['style' => 'text-align:right'],
											'footer' => $Total,
											'footerOptions' => ['style' => 'text-align:right; font-weight:bold; padding: 10px 15px'],
										],			
									],
								]); ?>
								<h4>Notes</h4>
								<?= GridView::widget([
									'dataProvider' => $notes,
									'tableOptions' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration',
									],
									'showFooter' =>false,
									'columns' => [
										[
											'class' => 'yii\grid\SerialColumn',
											'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
											'contentOptions' => ['style' => 'text-align:center'],
										],		
										[
											'label'=>'Note',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'Note',
											'contentOptions' => ['style' => 'text-align:left'],
										],
										[
											'label'=>'Created Date',
											'headerOptions' => [ 'width' => '17%', 'style'=>'color:black; text-align:left'],
											'format'=>'datetime',
											'value' => 'CreatedDate',
											'contentOptions' => ['style' => 'text-align:left'],
										],
										[
											'label'=>'Created By',
											'headerOptions' => [ 'width' => '15%', 'style'=>'color:black; text-align:left'],
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
	</div>
</section>
