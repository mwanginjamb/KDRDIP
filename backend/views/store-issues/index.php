<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Store Requisitions';
$this->params['breadcrumbs'][] = $this->title;
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
					<div class="card-body card-dashboard">

						<p>
							<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) : '' ?>	
						</p>

						<?= GridView::widget([
							'dataProvider' => $dataProvider,
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
									'value' => 'RequisitionLineID',
									'contentOptions' => ['style' => 'text-align:left'],
								], */
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'product',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'products.ProductName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Request Date',
									'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format' => ['date', 'php:d/m/Y'],
									'value' => 'CreatedDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Requested By',
									'headerOptions' => ['width' => '12%', 'style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'users.fullName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Requested',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
									'format'=> ['decimal', 2],
									'value' => 'Quantity',
									'contentOptions' => ['style' => 'text-align:right'],
								],
								[
									'label'=>'Issued',
									'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
									'format'=> ['decimal', 2],
									'value' => 'Issued',
									'contentOptions' => ['style' => 'text-align:right'],
								],
								[
									'label'=>'Balance',
									'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:right'],
									'format'=> ['decimal', 2],
									'value' => 'Balance',
									'contentOptions' => ['style' => 'text-align:right'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
									'template' => '{view} {delete}',
									'buttons' => [

										'view' => function ($url, $model) use ($rights) {
											return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->StoreRequisitionID], ['class' => 'btn-sm btn-primary']) : '';
										},
										'delete' => function ($url, $model) use ($rights) {
											return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->StoreRequisitionID], [
												'class' => 'btn-sm btn-danger btn-xs',
												'data' => [
													'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
													'method' => 'post',
												],
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
</section>

