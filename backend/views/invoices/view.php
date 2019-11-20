<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Invoices */

$this->title = 'View Invoice:' . $model->InvoiceID;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
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
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->InvoiceID], ['class' => 'btn btn-primary']) ?>
							<?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->InvoiceID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) ?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
								'attributes' => [
									'InvoiceID',
									'suppliers.SupplierName',
									[
										'attribute' => 'PurchaseID',
										'label' => 'PO No.',
									],
									[
										'attribute' => 'purchases.CreatedDate',
										'label' => 'PO Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									'InvoiceNumber',
									[
										'attribute' => 'InvoiceDate',
										'label' => ' Invoice Date',
										'format' => ['date', 'php:d/m/Y'],
									],
									[
										'attribute' => 'Amount',
										'format' => ['decimal', 2]
									],
									[
										'attribute' => 'CreatedDate',
										'label' => 'Created By',
										'format' => ['date', 'php:d/m/Y h:i a'],
									],							
									'users.fullName',
								],
						]) ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
