<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

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
						<div class="row">
							<div class="col-lg-5">
								<p>Enter Details below</p>
								<?php $form = ActiveForm::begin(); ?>
								<?= $form->field($model, 'IssueQuantity')->textInput(['type' => 'number']) ?>

								<div class="form-group">
									<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
									<?= Html::submitButton('<i class="ft-check"></i> Save', ['class' => 'btn btn-success']);?>
								</div>
								
								<?php ActiveForm::end(); ?>	
							</div>
						</div>

						<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
								'RequisitionLineID',
								'CreatedDate',
								[
									'label'=>'Requested By',
									'attribute' => 'users.fullName',
								],
								'products.ProductName',
								'Quantity',
								'Description:ntext',
								'Issued',
								'Balance'
							],
						]) ?>

							<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'showFooter' =>false,
							'columns' => [
								[
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'StoreIssueID',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Quantity',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:right'],
									'format'=>['decimal',2],
									'value' => 'Quantity',
									'contentOptions' => ['style' => 'text-align:right'],
								],
								[
									'label'=>'Issue Date',
									'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format' => ['date', 'php:d/m/Y'],
									'value' => 'CreatedDate',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'label'=>'Issued By',
									'value' => 'users.fullName',
								],
							],
						]); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
