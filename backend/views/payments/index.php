<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
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
						<div class="place-right">
							<?php $form = ActiveForm::begin(); ?>
							<div class="row">
								<div class="col-md-4">
									<?= $form->field($search, 'searchfor')->dropDownList($searchfor,['prompt'=>'Select...']) ?>
								</div>
								<div class="col-md-4">
									<?= $form->field($search, 'searchstring')->textInput() ?>	
								</div>
								<div class="col-md-4">
									<?= Html::submitButton('<i class="ft-search"></i> Search', ['class' => 'btn btn-primary', 'style' => 'margin-top: 27px;']); ?>
									<?= Html::submitButton('<i class="ft-download"></i> Export', ['name' => 'export', 'class' => 'btn btn-secondary', 'style' => 'margin-top: 27px;']); ?>
								</div>		
							</div>
							<?php ActiveForm::end(); ?>
						</div>
						<div class="form-actions" style="margin-top:0px">
							<?= Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) ?>
							<!-- <?= Html::a('<i class="ft-download"></i> Export', ['export'], ['class' => 'btn btn-primary mr-1']) ?>	 -->
						</div>

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
									'value' => 'PaymentID',
									'contentOptions' => ['style' => 'text-align:left'],
								],	 */
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],							
								[
									'attribute' => 'Date',
									'format' => ['date', 'php:d/m/Y'],
									'headerOptions' => ['width' => '15%'],
								],
								[
									'label'=>'Supplier',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'Supplier',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Payment Method',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'paymentMethods.PaymentMethodName',
									'contentOptions' => ['style' => 'text-align:left'],
								],								
								[
									'label'=>'Amount',
									'headerOptions' => ['width' => '10%', 'style'=>'text-align:right'],
									'format'=> ['decimal', 2],
									'value' => 'Amount',
									'contentOptions' => ['style' => 'text-align:right'],
								],
								[
									'label'=>'Reference',
									'headerOptions' => ['width' => '25%', 'style'=>'text-align:left'],
									'contentOptions' => ['style' => 'text-align:left'],
									'format'=>'text',
									'value' => 'RefNumber',
								],
								[
									'label'=>'Approval Status',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'approvalstatus.ApprovalStatusName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Approved Date',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
									'format'=>'date',
									'value' => 'ApprovalDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style'=>'color:black; text-align:center'],
									'template' => '{view} {delete}',
									'buttons' => [

										'view' => function ($url, $model)  {
											return  Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->PaymentID], ['class' => 'btn-sm btn-primary']);
										},
										'delete' => function ($url, $model) {
											return  Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->PaymentID], [
												'class' => 'btn-sm btn-danger btn-xs',
												'data' => [
													'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
													'method' => 'post',
												],
											]) ;
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
