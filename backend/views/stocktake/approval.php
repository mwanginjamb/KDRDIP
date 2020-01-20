<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StockTake */

$this->title = 'View Stock Take: '. $model->StockTakeID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Takes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 14;
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
									<?= Html::submitButton('Approve', ['class' => 'btn btn-success', 'name'=>'Approve']); ?>
									<?= Html::submitButton('Reject', ['class' => 'btn btn-danger', 'name'=>'Reject']); ?>
									<?= Html::a('Close', ['index', 'option' => $option], ['class' => 'btn btn-warning']) ?>
								</div>
								
								<?php ActiveForm::end(); ?>	
							</div>
						</div>

						<?= DetailView::widget([
							'model' => $model,
							'options' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'attributes' => [
									'StockTakeID',
								'Reason',
								'Notes:ntext',
								'CreatedDate',
								'CreatedBy',
								'users.Full_Name',
								'Notes:ntext',
								'ApprovalDate',
								'approvalstatus.ApprovalStatusName',            
							],
						]) ?>
						
						<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'layout' => '{items}',
						'tableOptions' => [
							'class' => 'custom-table table-striped table-bordered zero-configuration',
						],
						'showFooter' =>false,
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
