<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Deliveries */

$this->title = 'View Delivery: '.$model->DeliveryID;
$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 15;
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
						
						<?php
						$form = ActiveForm::begin(['id' => 'contact-form']); 				
							if (!$model->Posted)
							{ ?>
								<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->DeliveryID], ['class' => 'btn btn-primary']) :''; ?>
								<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->DeliveryID], [
														'class' => 'btn btn-danger',
														'data' => [
															'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
															'method' => 'post',
														],
													]) : ''; ?>
								<?= Html::a('<i class="ft-check"></i> Post', ['post', 'id' => $model->DeliveryID], [
											'class' => 'btn btn-success',
											'data' => [
												'confirm' => 'Are you sure you want to Post this item?',
												'method' => 'post',
											],
										]); ?>
								<?php
							} ?>
							<?= (isset($rights->View)) ? Html::a('GRN', ['grn', 'id' => $model->DeliveryID], ['class' => 'btn btn-primary place-right', 'style' => 'margin-right:10px']) : '' ?>
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
						<?php ActiveForm::end(); ?>
					</p>

					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
								'DeliveryID',
								'CreatedDate',
								[
								'label'=>'Requested By',
								'attribute' => 'users.Full_Name',
							] ,
								'PurchaseID',
								'DeliveryNoteNumber',
						],
					]) ?>
					
					<table width="100%" class="table table-striped table-bordered-min">
					<thead>
					<tr>
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: center;" width="5%">#</td>
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold;" width="15%">Code</td>
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold;">Product</td>
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold;" width="15%">Usage Unit</td>			
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: right" width="15%">Ordered</td>
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: right" width="15%">Received T.D.</td>
						<td style="padding: 4px 4px 4px 4px !important; font-weight: bold; text-align: right" width="15%">Delivered</td>
					</tr>	
					</thead>
					<?php 
					foreach ($lines as $x => $line) 
					{ ?>
						<tr>
							<td style="padding: 4px 4px 4px 4px !important; text-align: center;">
							<?= $x+1; ?></td>
							<td style="padding: 4px 4px 4px 4px !important"><?= $data[$x]['SupplierCode']; ?></td>
							<td style="padding: 4px 4px 4px 4px !important" ><?= $data[$x]['ProductName']; ?></td>
							<td style="padding: 4px 4px 4px 4px !important" ><?= $data[$x]['UsageUnitName']; ?></td>
							<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= $data[$x]['Quantity']; ?></td>
							<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= isset($delivered[$data[$x]['PurchaseLineID']]) ? $delivered[$data[$x]['PurchaseLineID']] : 0; ?></td>
							<td style="padding: 4px 4px 4px 4px !important;  text-align: right"><?= $data[$x]['DeliveredQuantity']; ?></td>
						</tr>
						<?php
					} ?>
					</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>