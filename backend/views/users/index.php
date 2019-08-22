<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
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
											<!-- <p class="card-text">List of Dirctors</p> -->
											<div class="form-actions" style="margin-top:0px">
												<?= Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) ?>	
											</div>
											<div class="table-responsive">
												
												<table class="table table-striped table-bordered zero-configuration">
													<thead>
															<tr>
																<th>Full Name</th>
																<th>Mobile</th>
																<th>Email</th>
																<th>Group</th>
																<th>Status</th>
																<th width="16%"></th>
															</tr>
													</thead>
													<tbody>
														<?php foreach($model as $key => $row) { ?>
															<tr>
																<td><?= $row->FirstName.' '.$row->LastName; ?></td>
																<td><?= $row->Mobile; ?></td>
																<td><?= $row->Email; ?></td>
																<td><?= $row->usergroups ? $row->usergroups->UserGroupName : ''; ?></td>
																<td><?= $row->userstatus ? $row->userstatus->UserStatusName : ''; ?></td>
																<td>
																	<?= Html::a('<i class="ft-edit"></i> Edit', ['update', 'id' => $row->UserID], ['class' => 'btn-sm btn-primary']) ?>
																	<?= Html::a('Delete', ['delete', 'id' => $row->UserID], [
																			'class' => 'btn btn-danger',
																			'data' => [
																				'confirm' => 'Are you sure you want to delete this item?',
																				'method' => 'post',
																			],
																	]) ?>
																</td>
															</tr>
															<?php
														} ?>
															
													</tbody>
													<!-- <tfoot>
															<tr>
																<th>Name</th>
																<th>Position</th>
																<th>Office</th>
																<th>Age</th>
																<th>Start date</th>
																<th>Salary</th>
															</tr>
													</tfoot> -->
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
