<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

// $this->title = 'View Quotation: '.$model->QuotationID;
switch ($model->ApprovalStatusID) {
	case 1:
		$this->title = 'Quotation Review:';
		break;
	case 2:
		$this->title = 'Quotation Approvals:';
		break;
	case 3:
		$this->title = 'Quotation Approved:';
		break;
	case 4:
		$this->title = 'Quotation Rejected:';
		break;
	default:
		$this->title = 'Quotation Review:';
}
$this->title = $this->title . ' ' . $model->QuotationID;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 26;
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
							<?= $form->field($notes, 'Note')->textarea(['rows' => 6]) ?>
							<input type="hidden" id="option" name="option" value="<?= $option; ?>">
							<?php // $form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

							<div class="form-group">
								<?= Html::submitButton('<i class="ft-check"></i> Approve', ['class' => 'btn btn-success', 'name'=>'Approve']); ?>
								<?= Html::submitButton('<i class="ft-x"></i> Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']); ?>
								<?= Html::a('<i class="ft-x"></i> Close', ['index', 'option' => $option], ['class' => 'btn btn-warning']) ?>
							</div>
							
							<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $detailmodel,
							'options' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'attributes' => [
								'QuotationID',
								'Description',
								'CreatedDate',
								[
									'attribute' => 'users.fullName',
									'label' => 'Created By',
								],
								'Notes:ntext',
								'ApprovalDate',
								'approvalstatus.ApprovalStatusName',
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
										/* echo $model->QuotationTypeID;
										print '<pre>';
										print_r($model); exit; */
										return ($model->QuotationTypeID == 1) ? $model->product->ProductName : $model->accounts->AccountName;
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
	</div>
</section>
