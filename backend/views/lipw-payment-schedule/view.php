<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LipwPaymentRequest */

$this->title = 'Payment Request ID: ' . $model->PaymentRequestID;
$this->params['breadcrumbs'][] = ['label' => 'Lipw Payment Requests', 'url' => ['index']];
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
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?php
							if ($model->ApprovalStatusID == 0) { ?>
								<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->PaymentRequestID], ['class' => 'btn btn-primary']) : '';?>
								<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->PaymentRequestID], [
										'class' => 'btn btn-danger',
										'data' => [
											'confirm' => 'Are you sure you want to delete this item?',
											'method' => 'post',
										],
								]) : '';?>
								
								<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Send for Approval', ['submit', 'id' => $model->PaymentRequestID], [
									'class' => 'btn btn-danger place-right', 'style' => 'width: 140px !important;margin-right: 5px;',
									'data' => [
												'confirm' => 'Are you sure you want to submit this item?',
												'method' => 'post',
											]
								]) : '' ?>
								<?php
							} ?>
						</p>	

						<ul class="nav nav-tabs nav-top-border no-hover-bg">
							<li class="nav-item">
								<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('lipw-payment-request-lines/index?pId=' . $model->PaymentRequestID);?>', 'tab2')">Beneficiaries</a>
							</li>	
							<li class="nav-item">
								<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false" onclick="loadpage('<?= Yii::$app->urlManager->createUrl('lipw-payment-schedule/schedule?pId=' . $model->PaymentRequestID);?>', 'tab3')">Payment Schedule/ Payroll</a>
							</li>										
						</ul>
						<div class="tab-content px-1 pt-1">
							<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
								<h4 class="form-section">Details</h4>

								<?= DetailView::widget([
									'model' => $model,
									'attributes' => [
										'PaymentRequestID',
										'lipwMasterRoll.MasterRollName',
										[
											'attribute' => 'StartDate',
											'format' => ['date', 'php:d/m/Y'],
										],
										[
											'attribute' => 'EndDate',
											'format' => ['date', 'php:d/m/Y'],
										],
										'lipwMasterRoll.subLocations.SubLocationName',
										'lipwMasterRoll.subLocations.locations.LocationName',
										'lipwMasterRoll.subLocations.locations.subCounties.SubCountyName',
										'lipwMasterRoll.subLocations.locations.subCounties.counties.CountyName',
										[
											'attribute' => 'lipwPaymentRequestStatus.PaymentRequestStatusName',
											'label' => 'Status',
										],
										[
											'attribute' => 'calculatedTotal',
											'format' => ['decimal', 2],
										],
										[
											'attribute' => 'CreatedDate',
											'format' => ['date', 'php:d/m/Y h:i a'],
										],
										[
											'label' => 'Created By',
											'attribute' => 'users.fullName',
										],
									],
								]) ?>
							</div>
							<div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
								<h4 class="form-section">Beneficiaries</h4>
							</div>
							<div class="tab-pane" id="tab3" aria-labelledby="base-tab3">
								<h4 class="form-section">Schedule</h4>
							</div>

						</div>	
					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
