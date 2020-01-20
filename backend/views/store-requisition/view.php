<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\StoreRequisition */

$this->title = 'View Store Requisition: ' . $model->StoreRequisitionID;
$this->params['breadcrumbs'][] = ['label' => 'Store Requisitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
						<?php if ($model->ApprovalStatusID == 0)
						{ ?>
							
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->StoreRequisitionID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->StoreRequisitionID], [
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
						if ($model->ApprovalStatusID == 0) { ?>
							<?= Html::a('Send for Approval', ['submit', 'id' => $model->StoreRequisitionID], [
								'class' => 'btn btn-danger', 'style' => 'width: 140px !important;margin-right: 5px;',
								'data' => [
											'confirm' => 'Are you sure you want to submit this item?',
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
									'StoreRequisitionID',
									'CreatedDate',
								[
									'label'=>'Requested By',
									'attribute' => 'users.fullName',
								] ,          
									'Notes:ntext',
									'PostingDate',
									'approvalstatus.ApprovalStatusName',
							],
						]) ?>

							<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'showFooter' =>false,
							'columns' => [
								/* [
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'RequisitionLineID',
									'contentOptions' => ['style' => 'text-align:left'],
								],	 */	
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
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
									'headerOptions' => ['width' => '45%','style'=>'color:black; text-align:right'],
									'format'=>'text',
									'value' => 'Description',
									'contentOptions' => ['style' => 'text-align:right'],
								],			
							],
						]); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
