<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ($option==1) ? 'Payment Review' : 'Payment Approvals';

switch ($option) {
	case 1:
		$this->title = 'Payment Review';
		break;
	case 2:
		$this->title = 'Payment Approvals';
		break;
	case 3:
		$this->title = 'Payment Approved';
		break;
	case 4:
		$this->title = 'Payment Rejected';
		break;
	default:
		$this->title = 'Payment Review';
}

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
					<div class="card-body card-dashboard">
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
								], */	
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
									'value' => 'suppliers.SupplierName',
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
									'label'=>'Email',
									'headerOptions' => ['width' => '25%', 'style'=>'text-align:left'],
									'contentOptions' => ['style' => 'text-align:left'],
									'format'=>'text',
									'value' => 'RefNumber',
								],
								[
									'label'=>'Requested By',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'users.Full_Name',
									'contentOptions' => ['style' => 'text-align:left'],
								],			
								[
									'label'=>'Approval Status',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'approvalstatus.ApprovalStatusName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
									[
									'label'=>'Posting Date',
									'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:left'],
									'format'=>'date',
									'value' => 'PostingDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'class' => 'yii\grid\ActionColumn', 
									'headerOptions' => ['width' => '7%', 'style'=>'color:black; text-align:center'],
									'template' => '{update}',
									'buttons' => [

										//update button
										'update' => function ($url, $model) use ($Rights, $FormID, $option) {
											$baseUrl = Yii::$app->request->baseUrl;
											return Html::a('<i class="ft-eye"></i> Select', $baseUrl.'/payments-approvals/view?id=' . $model->InvoiceID.'&option=' . $option, [
														'title' => Yii::t('app', 'Select'),
														'class'=>'btn-sm btn-primary btn-xs',
														]);
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
