<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mpesa Transactions';
$this->params['breadcrumbs'][] = $this->title;
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
												
												<table class="table table-striped table-bordered zero-configuration">
													<thead>
															<tr>
																<th>Trans ID</th>
																<th>Trans Amount</th>
																<th>Trans Time</th>
																<th>Mobile</th>
																<th>Name</th>
																<th>Created Date</th>
																<th width="10%"></th>
															</tr>
													</thead>
													<tbody>
														<?php foreach($model as $key => $row) { ?>
															<tr>																
																<td><?= $row->TransID; ?></td>
																<td><?= $row->TransAmount; ?></td>
																<td><?= $row->TransTime; ?></td>
																<td><?= $row->MSISDN; ?></td>
																<td><?= $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName; ?></td>
																<td><?= $row->CreatedDate; ?></td>
																<td>
																	<?= Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $row->TransactionID], ['class' => 'btn-sm btn-primary']) ?>
																</td>
															</tr>
															<?php
														} ?>
															
													</tbody>
												</table>
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
