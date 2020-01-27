<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\StockTake */

$this->title = 'View Stock Take: '. $model->StockTakeID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Takes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 11;
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
						<?php if ($model->ApprovalStatusID == 0)
						{ ?>
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->StockTakeID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->StockTakeID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) ?>	
							<?php
						}
						?>

						<?php if ($model->ApprovalStatusID == 0)
						{ ?>
							<?= Html::a('Send for Approval', ['submit', 'id' => $model->StockTakeID], [
								'class' => 'btn btn-danger', 'style' => 'width: 140px !important;margin-right: 5px;',
								'data' => [
											'confirm' => 'Are you sure you want to submit this item?',
											'method' => 'post',
										]
								]); ?>
							<?php
						}
						?>
					<?= DetailView::widget([
						'model' => $model,
						'options' => [
							'class' => 'custom-table table-striped table-bordered zero-configuration',
						],
						'attributes' => [
							'StockTakeID',
							'stores.StoreName',
							'Reason',
							'Notes:ntext',
							'CreatedDate',
							[
								'label'=>'Requested By',
								'attribute' => 'users.fullName',
							],
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
							/* [
								'label'=>'ID',
								'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								'contentOptions' => ['style' => 'text-align:center'],
								'format'=>'text',
								'value' => 'StockTakeLineID',
								'contentOptions' => ['style' => 'text-align:left'],
							],	 */
							[
								'class' => 'yii\grid\SerialColumn',
								'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
							],	
							[
								'label'=>'Product ID',
								'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
								'format'=>'text',
								'value' => 'ProductID',
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
								'label'=>'Category',
								'headerOptions' => ['width' => '20%','style'=>'color:black'],
								'format'=>'text',
								'value' => 'product.productcategory.ProductCategoryName',
								'contentOptions' => [],
							],		
							[
								'label'=>'Usage Unit',
								'headerOptions' => ['width' => '10%','style'=>'color:black'],
								'format'=>'text',
								'value' => 'product.usageunit.UsageUnitName',
								'contentOptions' => [],
							],	
							[
								'label'=>'Current Stock',
								'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
								'format'=>['decimal',2],
								'value' => 'CurrentStock',
								'contentOptions' => ['style' => 'text-align:right'],
							],
							[
								'label'=>'Physical Stock',
								'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
								'format'=>['decimal',2],
								'value' => 'PhysicalStock',
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
