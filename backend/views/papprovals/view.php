<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */

// $this->title = 'View Purchase: '.$model->PurchaseID;
switch ($model->ApprovalStatusID) {
	case 1:
		$this->title = 'Purchase Review:';
		break;
	case 2:
		$this->title = 'Purchase Approvals:';
		break;
	case 3:
		$this->title = 'Purchase Approved:';
		break;
	case 4:
		$this->title = 'Purchase Rejected:';
		break;
	default:
		$this->title = 'Purchase Review:';
}
$this->title = $this->title . ' ' . $model->PurchaseID;
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 13;

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
						<div class="row">
							<div class="col-lg-6">
								<p>Enter Approval details below</p>
								<?php $form = ActiveForm::begin(); ?>
								<?= $form->field($notes, 'Note')->textarea(['rows' => 3]) ?>
								<input type="hidden" id="option" name="option" value="<?= $option; ?>">
								<?php //$form->field($model, 'ApprovalStatusID')->dropDownList($approvalstatus,['prompt'=>'Select...']) ?>

								<div class="form-group">
									<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
									<?= (isset($rights->Edit)) ? Html::submitButton('Approve', ['class' => 'btn btn-success', 'name'=>'Approve']) : '';?>
									<?= (isset($rights->Edit)) ? Html::submitButton('Adjustment', ['class' => 'btn btn-primary', 'name'=>'Adjustment']) : ''; ?>
									<?= (isset($rights->Edit)) ? Html::submitButton('Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']) : ''; ?>
								</div>
								
								<?php ActiveForm::end(); ?>	
							</div>
						</div>
						<?= DetailView::widget([
							'model' => $detailmodel,
							'attributes' => [
								'PurchaseID',
								'CreatedDate',
								'users.fullName',
								'suppliers.SupplierName',
								'Notes:ntext',
								'PostingDate',
								'approvalstatus.ApprovalStatusName',
							],
						]) ?>

						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'showFooter' =>true,
							'columns' => [
								/* [
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'PurchaseLineID',
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
									'label'=>'Usage Unit',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'usageunit.UsageUnitName',
									'contentOptions' => ['style' => 'text-align:left'],
								],				
								[
									'label'=>'Unit Price',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
									'format'=>['decimal',2],
									'value' => 'UnitPrice',
									'contentOptions' => ['style' => 'text-align:right'],
								],	
								[
									'label'=>'Total',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
									'format'=>['decimal',2],
									'value' => 'Unit_Total',
									'footer' => $Total,
									'contentOptions' => ['style' => 'text-align:right'],
									'footerOptions' => ['style' => 'text-align:right; font-weight:bold'],
								],				
							],
						]); ?>
						<h4>Notes</h4>
						<?= GridView::widget([
							'dataProvider' => $approvalnotes,
							'showFooter' =>false,
							'columns' => [
								/* [
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
									'contentOptions' => ['style' => 'text-align:center'],
								],	 */	
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
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
</section>