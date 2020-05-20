<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

// $this->title = 'View Invoice: '.$model->InvoiceID;
switch ($model->ApprovalStatusID) {
	case 1:
		$this->title = 'Request Review:';
		break;
	case 2:
		$this->title = 'Request Approvals:';
		break;
	case 3:
		$this->title = 'Request Approved:';
		break;
	case 4:
		$this->title = 'Request Rejected:';
		break;
	default:
		$this->title = 'Request Review:';
}
$this->title = $this->title . ' ' . $model->PaymentRequestID;
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
					<div class="card-body">
						<div class="row">
							<div class="col-lg-5">
								<p>Enter Approval details below</p>
							<?php $form = ActiveForm::begin(); ?>
							<?= $form->field($notes, 'Note')->textarea(['rows' => 3]) ?>
							<input type="hidden" id="option" name="option" value="<?= $option; ?>">
							<?php // $form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

							<div class="form-group">
								<?= Html::a('<i class="ft-x"></i> Close', ['index', 'option' => $option], ['class' => 'btn btn-warning mr-1']) ?>
								<?= Html::submitButton('<i class="ft-check"></i> Approve', ['class' => 'btn btn-success', 'name'=>'Approve']);?>
								<?= Html::submitButton('<i class="ft-x"></i> Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']); ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
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

						<h4 class="form-section" style="margin-bottom: 0px">Beneficiaries</h4>
						<?= GridView::widget([
							'dataProvider' => $requestLines,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%'],
								],
								[
									'label' => 'Beneficiary',
									'attribute' => 'lipwWorkRegister.lipwBeneficiaries.BeneficiaryName',
								],
								[
									'label' => 'ID Number',
									'attribute' => 'lipwWorkRegister.lipwBeneficiaries.IDNumber',
									'format' => 'text',
									'headerOptions' => ['width' => '10%'],
								],
								[
									'attribute' => 'Amount',
									'format' => ['decimal', 2],
									'headerOptions' => ['width' => '10%', 'style' => 'text-align: right'],
									'contentOptions' => ['style' => 'text-align: right'],
								],
								[
									'attribute' => 'CreatedDate',
									'format' => ['date', 'php:d/m/Y h:i a'],
									'headerOptions' => ['width' => '15%'],
								],
								[
									'label' => 'Created By',
									'attribute' => 'users.fullName',
									'headerOptions' => ['width' => '15%'],
								],
							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
