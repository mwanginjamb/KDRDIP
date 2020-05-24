<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
$baseUrl = Yii::$app->request->baseUrl;
$this->title = 'Monitoring $ Evaluation';
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
$(window).on("load", function(){
	Morris.Donut({
		element: 'sessions-browser-donut-chart1',
		data: <?= $graph1; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});
	console.log(<?= $bar1; ?>);
	Morris.Bar({
		element: 'sessions-browser-bar1',
		data: <?= $bar1; ?>,
		xkey: 'y',
		ykeys: ['a'],
		labels: ['No. '],
		barGap: 6,
		barSizeRatio: 0.35,
		xLabelAngle: 90,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8']
	});

	Morris.Donut({
		element: 'payment-status-chart',
		data: <?= $graph2; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});

	Morris.Bar({
		element: 'payment-status-bar',
		data: <?= $bar2; ?>,
		xkey: 'y',
		ykeys: ['a'],
		labels: ['No. '],
		barGap: 6,
		barSizeRatio: 0.35,
		xLabelAngle: 90,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8']
	});

	Morris.Donut({
		element: 'invoices-status-chart',
		data: <?= $graph3; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});

	Morris.Bar({
		element: 'invoices-status-bar',
		data: <?= $bar3; ?>,
		xkey: 'y',
		ykeys: ['a'],
		labels: ['No. '],
		barGap: 6,
		barSizeRatio: 0.35,
		xLabelAngle: 90,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8']
	});

	Morris.Donut({
		element: 'quotations-status-chart',
		data: <?= $graph4; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});

	Morris.Bar({
		element: 'quotations-status-bar',
		data: <?= $bar4; ?>,
		xkey: 'y',
		ykeys: ['a'],
		labels: ['No. '],
		barGap: 6,
		barSizeRatio: 0.35,
		xLabelAngle: 90,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8']
	});

	Morris.Donut({
		element: 'purchases-status-chart',
		data: <?= $graph5; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});

	Morris.Bar({
		element: 'purchases-status-bar',
		data: <?= $bar5; ?>,
		xkey: 'y',
		ykeys: ['a'],
		labels: ['No. '],
		barGap: 6,
		barSizeRatio: 0.35,
		xLabelAngle: 90,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8']
	});
		
	Morris.Bar({
		element: 'monthly-sales1',
		data: [{
					y: '2016',
					a: 650,
					b: 420
			}, {
					y: '2015',
					a: 540,
					b: 380
			}, {
					y: '2014',
					a: 480,
					b: 360
			}, {
					y: '2013',
					a: 320,
					b: 390
			}
		],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Data 1', 'Data 2'],
		barGap: 6,
		barSizeRatio: 0.35,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8', '#FF7D4D']
	});
});
</script>
<!-- Project Management -->
<section class="flexbox-container">

	<div class="card" style="padding: 15px;">
		<div class="card-content collapse show">
			<?php $form = ActiveForm::begin(); ?>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($dashboardFilter, 'ComponentID')->dropDownList($components, ['prompt' => 'Select...']) ?>
				</div>
				<div class="col-md-6">
					<?= Html::submitButton('<i class="ft-search"></i> Filter', ['class' => 'btn btn-primary', 'style' => 'margin-top: 25px']) ?>
				</div>			
			</div>
			
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</section>
<div class="row">

	<div id="recent-sales" class="col-xl-6 col-12" >
		<div class="card" style="height:500px; overflow:auto; overflow-x: hidden">
			<div class="card-header">
				<h4 class="card-title">Project Budget</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="invoice-summary.html" target="_blank">View all</a></li>
					</ul>
				</div>
			</div>
			<div class="card-content mt-1">
				<div class="table-responsive">
					<table id="recent-orders" class="table table-hover table-xl mb-0">
						<thead>
							<tr>
								<th class="border-top-0">Project</th>
								<th class="border-top-0">Usage</th>
								<th class="border-top-0" style="text-align:right">Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($budget as $item) {?>
								<tr>
									<td class="text-truncate"><?= $item['ProjectName']; ?></td>
									<td>
											<div class="progress progress-sm mt-1 mb-0 box-shadow-2">
												<div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
									</td>
									<td class="text-truncate" style="text-align:right"><?= number_format($item['TotalBudget'], 2); ?></td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6 col-12" >			
		<div class="card" style="height:500px; overflow:auto; overflow-x: hidden">
			<div class="card-header">
				<h4 class="card-title">Projects by Status</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
							<li><a href="#">Show all</a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-6">
							<div id="sessions-browser-donut-chart1" class="height-200"></div>
						</div>
						<div class="col-6">
							<div id="sessions-browser-bar1" class="height-250"></div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="custom-table mb-0 table-bordered">
							<tbody>
								<?php foreach ($projectStatus as $status) { ?>
									<tr>
										<th scope="row" class="border-top-0"><?= $status['ProjectStatusName']; ?></th>
										<td class="border-top-0"><?= (integer) $status['Total']; ?></td>
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

<!-- Finance Charts -->
<div class="row match-height">
	<div class="col-xl-6 col-12">			
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Payments Approval by Status</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
							<li><a href="#">Show all</a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-6">
							<div id="payment-status-chart" class="height-200"></div>
						</div>
						<div class="col-6">
							<div id="payment-status-bar" class="height-250"></div>
						</div>						
					</div>
					<div class="table-responsive">
						<table class="custom-table mb-0 table-bordered">
							<tbody>
								<?php foreach ($paymentStatus as $status) { ?>
									<tr>
										<th scope="row" class="border-top-0"><?= $status['ApprovalStatusName']; ?></th>
										<td class="border-top-0"><?= (integer) $status['Total']; ?></td>
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

	<div class="col-xl-6 col-12">			
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Invoices Approval by Status</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
							<li><a href="#">Show all</a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-6">
							<div id="invoices-status-chart" class="height-200"></div>
						</div>
						<div class="col-6">
							<div id="invoices-status-bar" class="height-250"></div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="custom-table mb-0 table-bordered">
							<tbody>
								<?php foreach ($invoicesStatus as $status) { ?>
									<tr>
										<th scope="row" class="border-top-0"><?= $status['ApprovalStatusName']; ?></th>
										<td class="border-top-0"><?= (integer) $status['Total']; ?></td>
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

<div class="row">
	<div class="col-xl-6 col-12">			
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Quotations Approvals by Status</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
							<li><a href="#">Show all</a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-6">
							<div id="quotations-status-chart" class="height-200"></div>
						</div>
						<div class="col-6">
							<div id="quotations-status-bar" class="height-250"></div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="custom-table mb-0 table-bordered">
							<tbody>
								<?php foreach ($quotationStatus as $status) { ?>
									<tr>
										<th scope="row" class="border-top-0"><?= $status['ApprovalStatusName']; ?></th>
										<td class="border-top-0"><?= (integer) $status['Total']; ?></td>
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

	<div class="col-xl-6 col-12">			
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Purchases Approvals by Status</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
							<li><a href="#">Show all</a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-6">
							<div id="purchases-status-chart" class="height-200"></div>
						</div>
						<div class="col-6">
							<div id="purchases-status-bar" class="height-250"></div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="custom-table mb-0 table-bordered">
							<tbody>
								<?php foreach ($purchasesStatus as $status) { ?>
									<tr>
										<th scope="row" class="border-top-0"><?= $status['ApprovalStatusName']; ?></th>
										<td class="border-top-0"><?= (integer) $status['Total']; ?></td>
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

<!-- Procurement -->
<div class="row match-height">
	<div class="col-12 col-xl-6">
		<div class="card">
				<div class="card-header">
					<h4 class="card-title">Comparison</h4>					
				</div>
				<div class="card-content">
					<div class="table-responsive">
						<table class="table table-de mb-0">
								<thead>
									<tr>
										<th>Description</th>
										<th>Last Year</th>
										<th>Current Year</th>
									</tr>
								</thead>
								<tbody>
									<tr class="bg-success bg-lighten-5">
										<td>Suppliers</td>
										<td>0.45000000</td>
										<td>$ 4762.53</td>
									</tr>
									<tr>
										<td>Requisitions</td>
										<td><i class="cc BTC-alt"></i> 0.04000000</td>
										<td>$ 423.34</td>
									</tr>
									<tr>
										<td>Quotations</td>
										<td><i class="cc BTC-alt"></i> 0.25100000</td>
										<td>$ 2656.51</td>
									</tr>
									<tr>
										<td>Store Requisitions</td>
										<td><i class="cc BTC-alt"></i> 0.35000000</td>
										<td>$ 3704.33</td>
									</tr>
								</tbody>
						</table>
					</div>
				</div>
		</div>
	</div>
	<div class="col-12 col-xl-6">
		<div class="card">
				<div class="card-content">
					<div class="card-body sales-growth-chart">
						<div id="monthly-sales1" class="height-250"></div>
					</div>
				</div>
				<div class="card-footer">
					<div class="chart-title mb-1 text-center">
						<h6>Indicator Targets Vs Actual</h6>
					</div>
				</div>
		</div>
	</div>
</div>

