<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Predictions';
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
												<?= Html::a('<i class="ft-plus"></i> Add', ['index'], ['class' => 'btn btn-primary mr-1']) ?>	
											</div>
											<div class="table-responsive">
												
												<table class="table table-striped table-bordered zero-configuration">
													<thead>
															<tr>
																<th>Region</th>
																<th>League</th>
																<th>Game Time</th>
																<th>Teams</th>
																<th>Prediction</th>
																<th>Final Outcome</th>
																<th>Results</th>
																<th>Free</th>
																<th width="13%"></th>
															</tr>
													</thead>
													<tbody>
														<?php foreach($model as $key => $row) { ?>
															<tr>
																<td><?= $row->regions ? $row->regions->RegionName : ''; ?></td>
																<td><?= $row->leagues ? $row->leagues->LeagueName : ''; ?></td>
																<td><?= $row->GameTime; ?></td>
																<td><?= $row->Teams; ?></td>
																<td><?= $row->Prediction; ?></td>
																<td><?= $row->FinalOutcome; ?></td>
																<td><?= $row->Results; ?></td>
																<td><?= $row->Free == 1 ? 'Yes' : 'No'; ?></td>
																<td>
																	<?= Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $row->PredictionID], ['class' => 'btn-sm btn-primary mr-1']) ?>
																	<!-- <?= Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $row->PredictionID], [
																			'class' => 'btn-sm btn-danger',
																			'data' => [
																				'confirm' => 'Are you sure you want to delete this item?',
																				'method' => 'post',
																			],
																	]) ?> -->
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
