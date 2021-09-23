<?php

/* @var $this yii\web\View */

$this->title = 'CRM 2.0';
$baseUrl = Yii::$app->request->baseUrl;
// echo $complaintsArray[1]; exit;
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<script>
// Feed Graph Data
dayLabel = [<?= implode(', ', $days); ?>]; // ["1st", "2nd", "3rd", "4th", "5th", "6th", "7th"];
dayData = [<?= implode(', ', $dayData); ?>];// [0, 4500, 2600, 6100, 2600, 6500, 3200];
weekLabel = [<?= implode(', ', $weeks); ?>]; // ["W1", "W2", "W4", "W5", "W6", "W7", "W8"];
weekData = [<?= implode(', ', $weekData); ?>]; // [77000, 18000, 61000, 26000, 58000, 32000, 70000, 45000];
monthLabel = [<?= implode(', ', $months); ?>]; // ["AUG", "SEP", "OTC", "NOV", "DEC", "JAN", "FEB"];
monthData = [<?= implode(', ', $monthData); ?>]; // [100000, 500000, 300000, 700000, 100000, 200000, 700000, 50000];

$(window).on("load", function(){
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
		element: 'beneficiaries-sectors-chart',
		data: <?= $graph4; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});

	Morris.Bar({
		element: 'beneficiaries-sectors-bar',
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
		element: 'beneficiaries-categories-chart',
		data: <?= $graph5; ?>,
		resize: true,
		colors: ['#40C7CA', '#FF7588', '#2DCEE3', '#FFA87D', '#16D39A']
	});

	Morris.Bar({
		element: 'beneficiaries-categories-bar',
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
		element: 'beneficiaries-counties',
		data: <?= $beneficiariesByCounty; ?>,
		xkey: 'y',
		ykeys: ['a', 'b', 'c', 'd'],
		labels: ['Women', 'Men', 'Youth', 'Minority'],
		barGap: 6,
		barSizeRatio: 0.35,
		smooth: true,
		gridLineColor: '#e3e3e3',
		numLines: 5,
		gridtextSize: 14,
		fillOpacity: 0.4,
		resize: true,
		barColors: ['#00A5A8', '#FF7D4D', '#FFA87D', '#16D39A']
	});
});
</script>

<!-- <section id="configuration">
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
							</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="card-body card-dashboard">
						

					</div>
				</div>										  
			</div>
		</div>
	</div>
</section> -->

<section id="configuration1">
<div ></div>
<!-- <div class="app-content content"> -->
	<div class="content-header row">
	</div>
	<div class="content-wrapper1">
		<div class="content-body">
            <!-- eCommerce statistic -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="info"><?= number_format(isset($complaintsArray[1]) ? $complaintsArray[1] : 0, 0); ?></h3>
                                                <h6>New Enquiries</h6>
                                            </div>
                                            <div>
                                                <i class="icon-notebook info font-large-2 float-right"></i>
                                            </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="warning"><?= number_format(isset($complaintsArray[3]) ? $complaintsArray[3] : 0, 0); ?></h3>
                                                <h6>Under Review</h6>
                                            </div>
                                            <div>
                                                <i class="icon-eye warning font-large-2 float-right"></i>
                                            </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="success"><?= number_format(isset($complaintsArray[4]) ? $complaintsArray[4] : 0, 0); ?></h3>
                                                <h6>Resolved</h6>
                                            </div>
                                            <div>
                                                <i class="icon-bulb success font-large-2 float-right"></i>
                                            </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="danger"><?= number_format(isset($complaintsArray[5]) ? $complaintsArray[5] : 0, 0); ?></h3>
                                                <h6>Closed</h6>
                                            </div>
                                            <div>
                                                <i class="icon-drawer danger font-large-2 float-right"></i>
                                            </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!--/ eCommerce statistic -->

            <!-- Products sell and New Orders -->
            <div class="row match-height">
            <div class="col-xl-8 col-12" id="ecommerceChartView">
                    <div class="card card-shadow">
                            <div class="card-header card-header-transparent py-20">
                                <div class="btn-group dropdown">
                                    <a href="#" class="text-body dropdown-toggle blue-grey-700" data-toggle="dropdown">ENQUIRY TREND</a>
                                    <!-- <div class="dropdown-menu animate" role="menu">
                                            <a class="dropdown-item" href="#" role="menuitem">Complaints</a>
                                            <a class="dropdown-item" href="#" role="menuitem">Total Complaints</a>
                                            <a class="dropdown-item" href="#" role="menuitem">profit</a>
                                    </div> -->
                                </div>
                                <ul class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" role="group">
                                    <li class="nav-item"><a class="active nav-link" data-toggle="tab" href="#scoreLineToDay">Day</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToWeek">Week</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToMonth">Month</a></li>
                                </ul>
                            </div>
                            <div class="widget-content tab-content bg-white p-20">
                                <div class="ct-chart tab-pane active scoreLineShadow" id="scoreLineToDay"></div>
                                <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToWeek"></div>
                                <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToMonth"></div>
                            </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">New Enquiries</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div id="new-orders" class="media-list position-relative">
                                    <div class="table-responsive">
                                            <table id="new-orders-table" class="table table-hover table-xl mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="border-top-0" width="10%">ID</th>
                                                        <th class="border-top-0">Customer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($newComplaints as $complaint) { ?>
                                                        <tr>
                                                            <td class="text-truncate"><?= $complaint->ComplaintID; ?></td>
                                                            <td class="text-truncate"><?= $complaint->ComplainantName; ?></td>
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
            <!--/ Products sell and New Orders -->

            <!-- Recent Transactions -->
            <div class="row">
                <div id="recent-transactions" class="col-12">
                    <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent Closed Enquiries</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0" width="5%">Enquiry ID</th>
                                                    <th class="border-top-0">Customer</th>
                                                    <th class="border-top-0" width="15%">Nature of Enquiry</th>
                                                    <th class="border-top-0" width="15%">Section</th>
                                                    <th class="border-top-0" width="15%">Service</th>
                                                    <th class="border-top-0" width="12%">Date Closed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php	foreach ($closedComplaints as $complaint) { ?>
                                                    <tr>
                                                        <td class="text-truncate"><i class="la la-dot-circle-o success font-medium-1 mr-1"></i> <?= $complaint->complaintId; ?></td>
                                                        <td class="text-truncate"><a href="#"><?= $complaint->complainantName; ?></a></td> 
                                                        <td class="text-truncate"><?= $complaint->enquiryNature->enquiryNatureName ?></td>
                                                        <td class="text-truncate"><?= $complaint->section->sectionName ?></td>
                                                        <td class="text-truncate"><?= $complaint->service->serviceName ?></td>
                                                        <td class="text-truncate"><?= $complaint->dateClosed ?></td>
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
            <!--/ Recent Transactions -->

            <div class="row match-height">
                <div class="col-xl-6 col-12">			
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Complaints By Status</h4>
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
                                            <?php foreach ($complaintStatus as $status) { ?>
                                                <tr>
                                                    <th scope="row" class="border-top-0"><?= $status['ComplaintStatusName']; ?></th>
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
                            <h4 class="card-title">Complaints By Sector</h4>
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
                                            <?php foreach ($projectSectors as $status) { ?>
                                                <tr>
                                                    <th scope="row" class="border-top-0"><?= $status['ProjectSectorName']; ?></th>
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

            <!-- Beneficiaties Start -->
            <div class="row match-height">
                <div class="col-xl-6 col-12">			
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Beneficiaries By Sector</h4>
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
                                        <div id="beneficiaries-sectors-chart" class="height-200"></div>
                                    </div>
                                    <div class="col-6">
                                        <div id="beneficiaries-sectors-bar" class="height-250"></div>
                                    </div>						
                                </div>
                                <div class="table-responsive">
                                    <table class="custom-table mb-0 table-bordered">
                                        <tbody>
                                            <?php foreach ($beneficiariesSectors as $data) { ?>
                                                <tr>
                                                    <th scope="row" class="border-top-0"><?= $data['ProjectSectorName']; ?></th>
                                                    <td class="border-top-0"><?= (integer) $data['Total']; ?></td>
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
                            <h4 class="card-title">Beneficiaries By Category</h4>
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
                                        <div id="beneficiaries-categories-chart" class="height-200"></div>
                                    </div>
                                    <div class="col-6">
                                        <div id="beneficiaries-categories-bar" class="height-250"></div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="custom-table mb-0 table-bordered">
                                        <tbody>
                                            <?php foreach ($beneficiariesByCategory as $data) { ?>
                                                <tr>
                                                    <th scope="row" class="border-top-0"><?= $data['CategoryName']; ?></th>
                                                    <td class="border-top-0"><?= (integer) $data['Total']; ?></td>
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
             <!-- Beneficiaties End -->
            
            <div class="card">
                <div class="card-content">
                    <div class="card-body sales-growth-chart">
                        <div id="beneficiaries-counties" class="height-250"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="chart-title mb-1 text-center">
                        <table class="" width="20%">
                            <tbody>                            
                                <tr>
                                    <td align="left">Women</td>
                                    <td style="background: #00A5A8" width="50%"></td>
                                </tr>
                                <tr>
                                    <td align="left">Men</td>
                                    <td style="background: #FF7D4D"></td>
                                </tr>
                                <tr>
                                    <td align="left">Youth</td>
                                    <td style="background: #FFA87D"></td>
                                </tr>
                                <tr>
                                    <td align="left">Minority</td>
                                    <td style="background: #16D39A"></td>
                                </tr>
                            </tbody>
                        </table>
                        <h6>Beneficiaries By County</h6>
                    </div>
                </div>
            </div>

		</div>
	</div>
<!-- </div> -->
</section>