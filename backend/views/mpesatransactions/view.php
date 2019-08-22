<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MpesaTransactions */

$this->title = $model->TransID . ' - ' . $model->FirstName . ' ' . $model->MiddleName . ' ' . $model->LastName;
$this->params['breadcrumbs'][] = ['label' => 'Mpesa Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="app-content content">
	<div class="content-header row">
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section class="flexbox-container">
				<div class="content-body">
					<!-- Zero configuration table -->
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
											<div class="table-responsive">

												<p>
													<?= Html::a('Close', ['index'], ['class' => 'btn btn-primary']) ?>
												</p>

												<?= DetailView::widget([
													'model' => $model,
													'attributes' => [
															'TransactionID',
															'TransactionType',
															'TransID',
															'TransAmount',
															'TransTime',
															'BusinessShortCode',
															'BillRefNumber',
															'InvoiceNumber',
															'OrgAccountBalance',
															'ThirdPartyTransID',
															'MSISDN',
															'FirstName',
															'MiddleName',
															'LastName',
															// 'TransactionStatusID',
															'CreatedDate',
															// 'CreatedBy',
															// 'Deleted',
													],
												]) ?>

											</div>
										</div>
									</div>										  
								</div>
							</div>
						</div>
					</section>
					<!--/ Zero configuration table -->
				</div>
			</section>
		</div>
	</div>
</div>
