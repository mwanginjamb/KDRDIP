<?php
$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;
use yii\helpers\ArrayHelper;

use backend\controllers\RightsController;

$currentPage = Yii::$app->controller->id;
$currentRoute = trim(Yii::$app->controller->module->requestedRoute);
$option = isset($_GET['option']) ? $_GET['option'] : '';
$cid = isset($_GET['cid']) ? $_GET['cid'] : '';
$etid = isset($_GET['etid']) ? $_GET['etid'] : '';
$m = isset($_GET['m']) ? $_GET['m'] : '';

// echo $currentPage;
// echo $currentRoute; exit;

use app\models\Components;
use app\models\EnterpriseTypes;

$components = Components::find()->all();
$enterpriseTypes = EnterpriseTypes::find()->all();

$rights = (array) RightsController::Permissions(0);

if (!empty($rights)) {
	foreach ($rights as $key => $right) {
		if ($right['View'] != 1) {
			unset($rights[$key]);
		}
	}
}
$rights = ArrayHelper::getColumn($rights, 'PageID');
?>

<!-- BEGIN: Main Menu-->

<div class="main-menu material-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
		<!-- <div class="user-profile">
			<div class="user-info text-center pb-2"><img class="user-img img-fluid rounded-circle w-25 mt-2" src="<?= $baseUrl; ?>/assets/images/kenya.png" alt="" />
					<div class="name-wrapper d-block dropdown mt-1"><a class="white dropdown-toggle" id="user-account" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="user-name"><?= $user->FirstName .' '. $user->LastName; ?></span></a>
						<div class="text-light">Admin</div>
						<div class="dropdown-menu arrow" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item"><i class="material-icons align-middle mr-1">person</i><span class="align-middle">Profile</span></a><a class="dropdown-item"><i class="material-icons align-middle mr-1">message</i><span class="align-middle">Messages</span></a><a class="dropdown-item"><i class="material-icons align-middle mr-1">attach_money</i><span class="align-middle">Balance</span></a><a class="dropdown-item"><i class="material-icons align-middle mr-1">settings</i><span class="align-middle">Settings</span></a><a class="dropdown-item" href="<?= $baseUrl; ?>/site/logout"><i class="material-icons align-middle mr-1">power_settings_new</i><span class="align-middle" >Log Out</span></a></div>
					</div>
			</div>
		</div> -->
		<div class="user-profile1" style="background-color: white; padding:5px; text-align:center" >
			<img src="<?= $baseUrl; ?>/assets/images/kenya.png" width="60%">			
		</div>
		<div class="main-menu-content">
			<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
					<?php if(Yii::$app->user->can('view-dashboard')){ ?>
					<li <?= ($currentPage == 'site') ? 'class="active"' : ''; ?> class=" nav-item"><a href="<?= $baseUrl;?>/site"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a>
					</li>
					<?php } ?>
					<?php if (Yii::$app->user->can('access-finance')) { ?>
					<li class=" nav-item"><a href="#"><i class="material-icons">account_balance</i><span class="menu-title" data-i18n="nav.project.main">Finance</span></a>
						<ul class="menu-content">
							<?php if (in_array(1, $rights)) { ?>
								<!--<li <?php /*($currentPage == 'accounts') ? 'class="active"' : ''; */?>><a class="menu-item" href="<?/*= $baseUrl;*/?>/accounts"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Chart of Accounts</span></a>
								</li>-->
							<?php } ?>
							<?php if (in_array(5, $rights)) { ?>
								<li <?= ($currentPage == 'bank-accounts') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/bank-accounts"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Bank Accounts</span></a>
								</li>
							<?php } ?>
							<?php if (in_array(21, $rights)) { ?>
								<li <?= ($currentPage == 'fixed-assets') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/fixed-assets"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Asset Register</span></a>
								</li>
							<?php } ?>
							<?php if (in_array(25, $rights)) { ?>
								<li <?= ($currentPage == 'invoices') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/invoices"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Invoices</span></a>
								</li>
							<?php } ?>
							<?php if (in_array(30, $rights)) { ?>
								<li <?= ($currentPage == 'payments') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payments"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payments</span></a>
								</li>
							<?php } ?>
							<?php if (in_array(132, $rights)) { ?>
								<li <?= ($currentPage == 'cash-disbursements') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/cash-disbursements"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Cash Disbursements</span></a>
								</li>
							<?php } ?>
							<?php if (in_array(100, $rights)) { ?>
								<li <?= ($currentPage == 'lipw-payment-schedule') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-payment-schedule"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">LIPW Payments</span></a>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [24, 29, 103, 133])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reviews</span></a>
									<ul class="menu-content">
										<?php if (in_array(24, $rights)) { ?>									
											<li <?= ($currentPage == 'invoice-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/invoice-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Invoices</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(29, $rights)) { ?>
											<li <?= ($currentPage == 'payments-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payments-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payments</span></a>
											</li>	
										<?php } ?>	
										<?php if (in_array(103, $rights)) { ?>
											<li <?= ($currentPage == 'lipw-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">LIPW Payment</span></a>
											</li>	
										<?php } ?>
										<?php if (in_array(133, $rights)) { ?>
											<li <?= ($currentPage == 'cash-disbursement-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/cash-disbursement-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Cash Disbursements</span></a>
											</li>	
										<?php } ?>
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [24, 29, 103, 134])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Approvals</span></a>
									<ul class="menu-content">
										<?php if (in_array(103, $rights)) { ?>
											<li <?= ($currentPage == 'lipw-approvals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-approvals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">LIPW Payment</span></a>
											</li>	
										<?php } ?>				
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [24, 29])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Rejected</span></a>
									<ul class="menu-content">	
										<?php if (in_array(24, $rights)) { ?>								
											<li <?= ($currentPage == 'invoice-approvals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/invoice-approvals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Invoices</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(29, $rights)) { ?>
											<li <?= ($currentPage == 'payments-approvals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payments-approvals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payments</span></a>
											</li>	
										<?php } ?>					
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [64, 65, 66, 67, 68, 96, 111, 112, 113, 114, 115])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reports</span></a>
									<ul class="menu-content">
										<?php if (in_array(64, $rights)) { ?>									
											<!-- <li <?= ($currentRoute == 'reports/payment-report') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/payment-report"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payments Report</span></a>
											</li> -->	
										<?php } ?>	
										<?php if (in_array(65, $rights)) { ?>							
											<li <?= ($currentRoute == 'reports/supplierbalances') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/supplierbalances"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Balances</span></a>
											</li>		
										<?php } ?>	
										<?php if (in_array(66, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/supplierstatement') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/supplierstatement"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Statement</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(67, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/asset-register') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/asset-register"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Asset Register</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(68, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/bank-transactions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/bank-transactions"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Sub Project Transaction</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(68, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/monthly-finance-report') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/monthly-finance-report"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Monthly Finance Report</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(96, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/projects-finance' && $cid == 0 ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/projects-finance?cid=0"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Project Finance Report</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(111, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/projects-cummulative-expenditure' && $cid == 0 ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/projects-cummulative-expenditure?cid=0"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Cummulative Expenditure</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(112, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/component-finance-report' && $cid == 0 ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/component-finance-report?cid=0"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Components Report</span></a>
											</li>
										<?php } ?>		
										<?php if (in_array(113, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/component1-report' && $cid == 0 ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/component1-report?cid=0"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Component 1 Report</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(114, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/component2-report' && $cid == 0 ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/component2-report?cid=0"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Component 2 Report</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(115, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/component3-report' && $cid == 0 ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/component3-report?cid=0"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Component 3 Report</span></a>
											</li>
										<?php } ?>		
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [7, 2, 28, 17, 8])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
									<ul class="menu-content">	
										<?php if (in_array(7, $rights)) { ?>	
											<li <?= ($currentPage == 'banks') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/banks"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Banks</span></a>
											</li>	
										<?php } ?>	
										<?php if (in_array(2, $rights)) { ?>						
											<li <?= ($currentPage == 'account-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/account-types"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Account Types</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(28, $rights)) { ?>
                                            <li <?= ($currentPage == 'payment-methods') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payment-methods"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payment Methods</span></a></li>
											<li <?= ($currentPage == 'payment-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payment-types"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payment Types</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(17, $rights)) { ?>
											<li <?= ($currentPage == 'currencies') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/currencies"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Currencies</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(8, $rights)) { ?>
											<li <?= ($currentRoute == 'bank-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/bank-types"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Bank Types</span></a>
											</li>
										<?php } ?>										
									</ul>
								</li>	
							<?php } ?>						
						</ul>
					</li>
					
					
					<li class=" nav-item"><a href="#"><i class="material-icons">account_balance</i><span class="menu-title" data-i18n="nav.project.main">Procurement</span></a>
						<ul class="menu-content">
							
								<li <?= ($currentPage == 'product') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/product"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Items</span></a>
								</li>	
							
													
								<li <?= ($currentPage == 'suppliers') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/suppliers"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Suppliers</span></a>
								</li>	
							
												
								<li <?= ($currentPage == 'requisition') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/requisition"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisition</span></a>
								</li>
							
							
								<li <?= ($currentPage == 'quotation') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/quotation"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotation</span></a>
								</li>
							
							
								<li <?= ($currentPage == 'purchases') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/purchases"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
								</li>	
							
							
								<li <?= ($currentPage == 'deliveries') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/deliveries"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Deliveries</span></a>
								</li>	
							
							
								<li <?= ($currentPage == 'stocktake') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stocktake"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take</span></a>
								</li>		
							
							
								<li <?= ($currentRoute == 'reports/procurement-plan') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/procurement-plan"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Procurement Plan</span></a>
								</li>		
							
							
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reviews</span></a>
									<ul class="menu-content">
										
											<li <?= ($currentPage == 'procurement-plan-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/procurement-plan-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Procurement Plan</span></a>
											</li>	
										
										
											<li <?= ($currentPage == 'procurement-line-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/procurement-line-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Procurement Plan Activity</span></a>
											</li>	
										
																		
											<li <?= ($currentPage == 'qapprovals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/qapprovals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotations</span></a>
											</li>
										
											<li <?= ($currentPage == 'papprovals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/papprovals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
											</li>
									
											<li <?= ($currentPage == 'approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisitions</span></a>
											</li>
										
											<li <?= ($currentRoute == 'srapprovals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/srapprovals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Store Requisitions</span></a>
											</li>	
										
											<li <?= ($currentRoute == 'stocktake/approvallist' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stocktake/approvallist?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take</span></a>
											</li>
																	
									</ul>
								</li>
							
							<?php if (count(array_intersect($rights, [40, 27, 49, 69, 70, 125, 126])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Approvals</span></a>
									<ul class="menu-content">		
										<?php if (in_array(125, $rights)) { ?>
											<li <?= ($currentPage == 'procurement-plan-approvals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/procurement-plan-approvals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Procurement Plan</span></a>
											</li>	
										<?php } ?>
										<?php if (in_array(126, $rights)) { ?>
											<li <?= ($currentPage == 'procurement-line-approvals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/procurement-line-approvals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Procurement Plan Activity</span></a>
											</li>	
										<?php } ?>
										<?php if (in_array(40, $rights)) { ?>							
											<li <?= ($currentPage == 'qapprovals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/qapprovals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotations</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(27, $rights)) { ?>
											<li <?= ($currentPage == 'papprovals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/papprovals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
											</li>	
										<?php if (in_array(69, $rights)) { ?>
										<?php } ?>
											<li <?= ($currentPage == 'approvals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/approvals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisitions</span></a>
											</li>	
										<?php if (in_array(49, $rights)) { ?>
										<?php } ?>
											<li <?= ($currentRoute == 'srapprovals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/srapprovals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Store Requisitions</span></a>
											</li>	
										<?php if (in_array(70, $rights)) { ?>
										<?php } ?>
											<li <?= ($currentRoute == 'stocktake/approvallist' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stocktake/approvallist?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take</span></a>
											</li>
										<?php } ?>							
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [40, 27, 49, 69, 70])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Rejected</span></a>
									<ul class="menu-content">
										<?php if (in_array(40, $rights)) { ?>									
											<li <?= ($currentPage == 'qapprovals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/qapprovals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotations</span></a>
											</li>
										<?php } ?>
										<?php if (in_array(27, $rights)) { ?>
											<li <?= ($currentPage == 'papprovals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/papprovals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
											</li>	
										<?php if (in_array(69, $rights)) { ?>
										<?php } ?>
											<li <?= ($currentPage == 'approvals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/approvals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisitions</span></a>
											</li>
										<?php if (in_array(49, $rights)) { ?>
										<?php } ?>	
											<li <?= ($currentRoute == 'srapprovals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/srapprovals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Store Requisitions</span></a>
											</li>	
										<?php if (in_array(70, $rights)) { ?>
										<?php } ?>
											<li <?= ($currentRoute == 'stocktake/approvallist' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stocktake/approvallist?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take</span></a>
											</li>	
										<?php } ?>						
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [53, 52, 51, 50])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Stores</span></a>
									<ul class="menu-content">	
										<?php if (in_array(53, $rights)) { ?>	
											<li <?= ($currentPage == 'stores') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stores"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stores</span></a>
											</li>	
										<?php if (in_array(52, $rights)) { ?>
										<?php } ?>						
											<li <?= ($currentPage == 'store-requisition') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/store-requisition"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisition</span></a>
											</li>	
										<?php if (in_array(51, $rights)) { ?>
										<?php } ?>								
											<li <?= ($currentPage == 'store-issues') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/store-issues"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Store Issues</span></a>
											</li>	
										<?php if (in_array(50, $rights)) { ?>
										<?php } ?>
											<li <?= ($currentPage == 'stock-take') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stock-take"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take</span></a>
											</li>
										<?php } ?>						
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [71, 72, 73, 74, 75, 76])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reports</span></a>
									<ul class="menu-content">	
										<?php if (in_array(71, $rights)) { ?>								
											<li <?= ($currentRoute == 'reports/inventoryreport') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/inventoryreport"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Inventory Report</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(72, $rights)) { ?>								
											<li <?= ($currentRoute == 'reports/purchasesreport') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/purchasesreport"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases Report</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(73, $rights)) { ?>	
											<li <?= ($currentRoute == 'reports/stocktakingreport') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/stocktakingreport"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take Report</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(74, $rights)) { ?>	
											<li <?= ($currentRoute == 'reports/stockvariancereport') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/stockvariancereport"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Variance Report</span></a>
											</li>	
										<?php } ?>	
										<?php if (in_array(75, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/puchasesummaryreport') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/puchasesummaryreport"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchase Summary</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(76, $rights)) { ?>
											<li <?= ($currentRoute == 'reports/stockreport') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/stockreport"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Report Report</span></a>
											</li>
										<?php } ?>	
									</ul>
								</li>
							<?php } ?>
							<?php if (count(array_intersect($rights, [32, 55, 58, 31])) > 0) { ?>
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
									<ul class="menu-content">
										<?php if (in_array(32, $rights)) { ?>									
											<li <?= ($currentPage == 'productcategory') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/productcategory"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Item Categories</span></a>
											</li>		
										<?php } ?>	
										<?php if (in_array(55, $rights)) { ?>							
											<li <?= ($currentPage == 'supplier-category') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/supplier-category"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Categories</span></a>
											</li>
										<?php } ?>	
										<?php if (in_array(58, $rights)) { ?>
											<li <?= ($currentPage == 'usage-units') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/usage-units"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Usage Units</span></a>
											</li>	
										<?php } ?>	
										<?php if (in_array(31, $rights)) { ?>	
											<li <?= ($currentRoute == 'reports/procurement-methods') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/procurement-methods"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Procurement Methods</span></a>
											</li>	
										<?php } ?>							
									</ul>
								</li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>
					<?php if (count(array_intersect($rights, [14, 22, 37, 47, 46, 35, 38, 57, 48, 12, 105, 96, 139, 140, 141, 142, 36, 143])) > 0) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">work_outline</i><span class="menu-title" data-i18n="nav.project.main">Project Management</span></a>
							<ul class="menu-content">
								<li <?= ($currentPage == 'taks-assigned') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/tasks-assigned"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Assigned Tasks</span></a>
								</li>
								<?php
								foreach ($components as $component) { ?>
								
									<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main" title="<?= $component->ComponentName; ?>"><?= $component->ShortName; ?></span></a>
									<ul class="menu-content">
										<?php
										if ($component->ComponentID != 3) { ?> 									
											<li <?= ($currentPage == 'projects' && $cid == $component->ComponentID ) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/projects?cid=<?= $component->ComponentID; ?>"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Sub-Projects</span></a>
											</li>
											<li <?= ($currentRoute == 'reports/progress-report' && $cid == $component->ComponentID) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/progress-report?cid=<?= $component->ComponentID; ?>"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Progress Report</span></a>
											</li>
											<li <?= ($currentRoute == 'reports/work-plan' && $cid == $component->ComponentID) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/work-plan?cid=<?= $component->ComponentID; ?>"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Work Plan</span></a>
											</li>
											<li <?= ($currentRoute == 'reports/budget' && $cid == $component->ComponentID) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/budget?cid=<?= $component->ComponentID; ?>"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Budget</span></a>
											</li>
											<li <?= ($currentRoute == 'reports/projects-report' && $cid == $component->ComponentID) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/projects-report?cid=<?= $component->ComponentID; ?>"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Sub-Projects Report</span></a>
											</li>
											<?php if (in_array(96, $rights)) { ?>
												<li <?= ($currentRoute == 'reports/projects-finance' && $cid == $component->ComponentID) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/projects-finance?cid=<?= $component->ComponentID; ?>"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Project Finance Report</span></a>
												</li>
											<?php } ?>
											<?php 
										} else { ?>
                                            <?php if (in_array(139, $rights)) { ?>
                                                <li <?= ($currentPage == 'organizations') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/organizations"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Community Groups</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if (in_array(140, $rights)) { ?>
                                                <li <?= ($currentPage == 'livelihood-activities') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/livelihood-activities"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Livelihood Activities</span></a>
                                                </li>
                                            <?php } ?>

                                            <?php if (in_array(141, $rights)) { ?>
                                                <li <?= ($currentPage == 'funding-years') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/funding-years"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Funding Years</span></a>
                                                </li>
                                            <?php } ?>

                                            <?php if (in_array(142, $rights)) { ?>
                                                <li <?= ($currentPage == 'age-groups') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/age-groups"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Age Groups</span></a>
                                                </li>
                                            <?php } ?>
                                            
                                            <?php if (in_array(143, $rights)) { ?>
                                                <li <?= ($currentPage == 'training-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/training-types"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Training Types</span></a>
                                                </li>
                                            <?php } ?>
                                            <?php
                                        }?>
									</ul>
								</li>
									<?php
								} ?>
								<?php if (in_array(14, $rights)) { ?>
									<li <?= ($currentPage == 'components') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/components"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Manage Components</span></a>
									</li>
								<?php } ?>
								<?php if (count(array_intersect($rights, [22, 37, 47, 46, 35, 38, 57, 48, 12, 77, 104, 108, 109, 123])) > 0) { ?>
									<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
										<ul class="menu-content">
                                            <li <?= ($currentPage == 'financial-year') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/financial-year"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Financial Years Setup</span></a>
                                            </li>
											<?php if (in_array(22, $rights)) { ?>								
												<li <?= ($currentPage == 'funding-sources') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/funding-sources"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Funding Sources</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(37, $rights)) { ?>
												<li <?= ($currentPage == 'project-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-status"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Status</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(47, $rights)) { ?>
												<li <?= ($currentPage == 'risk-rating') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/risk-rating"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Risk Rating</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(46, $rights)) { ?>
												<li <?= ($currentPage == 'risk-likelihood') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/risk-likelihood"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Risk Likelihood</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(35, $rights)) { ?>
												<li <?= ($currentPage == 'project-roles') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-roles"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Roles</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(38, $rights)) { ?>
												<li <?= ($currentPage == 'project-units') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-units"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Units</span></a>								
												</li>
											<?php } ?>
											<?php if (in_array(57, $rights)) { ?>
												<li <?= ($currentPage == 'units-of-measure') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/units-of-measure"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Units of Measure</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(48, $rights)) { ?>
												<li <?= ($currentPage == 'safeguarding-policies') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/safeguarding-policies"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Safeguarding Policies</span></a>
												</li>
											<?php } ?>
											<?php if (in_array(12, $rights)) { ?>
												<li <?= ($currentPage == 'communities') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/communities"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Communities</span></a>
												</li>	
											<?php } ?>	
											<?php if (in_array(77, $rights)) { ?>
												<li <?= ($currentPage == 'safeguards') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/safeguards"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Safeguards</span></a>
												</li>	
											<?php } ?>	
											<?php if (in_array(86, $rights)) { ?>
												<li <?= ($currentPage == 'enterprise-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/enterprise-types"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Enterprise Types</span></a>
												</li>	
											<?php } ?>
											<?php if (in_array(89, $rights)) { ?>
												<li <?= ($currentPage == 'community-group-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/community-group-status"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Community Group Status</span></a>
												</li>	
											<?php } ?>	
											<?php if (in_array(86, $rights)) { ?>
												<li <?= ($currentPage == 'group-roles') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/group-roles"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Group Roles</span></a>
												</li>	
											<?php } ?>	
											<?php if (in_array(86, $rights)) { ?>
												<li <?= ($currentPage == 'household-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/household-types"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Household Types</span></a>
												</li>	
											<?php } ?>
											<?php if (in_array(93, $rights)) { ?>
												<li <?= ($currentPage == 'master-indicators') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/master-indicators"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Master Indicators</span></a>
												</li>	
											<?php } ?>
											<?php if (in_array(94, $rights)) { ?>
												<li <?= ($currentPage == 'indicator-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/indicator-types"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Indicator Types</span></a>
												</li>	
											<?php } ?>	
											<?php if (in_array(95, $rights)) { ?>
												<li <?= ($currentPage == 'reporting-frequency') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reporting-frequency"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Reporting Frequency</span></a>
												</li>	
											<?php } ?>		
											<?php if (in_array(104, $rights)) { ?>
												<li <?= ($currentPage == 'project-sectors') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-sectors"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Sectors</span></a>
												</li>	
											<?php } ?>		
											<?php if (in_array(108, $rights)) { ?>
												<li <?= ($currentPage == 'project-sector-interventions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-sector-interventions"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Sectors Interventions</span></a>
												</li>	
											<?php } ?>
											<?php if (in_array(109, $rights)) { ?>
												<li <?= ($currentPage == 'sub-component-categories') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/sub-component-categories"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Sub Comp Categories</span></a>
												</li>	
											<?php } ?>		
											<?php if (in_array(123, $rights)) { ?>
												<li <?= ($currentPage == 'expense-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/expense-types"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Expense Types</span></a>
												</li>	
											<?php } ?>															
										</ul>
									</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>

					<?php if (count(array_intersect($rights, [20])) > 0) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Human Resources</span></a>
							<ul class="menu-content">
								<?php if (in_array(20, $rights)) { ?>
									<li <?= ($currentPage == 'employees') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/employees"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Employees</span></a>
									</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>

					<?php if (Yii::$app->user->can('access-safeguards')) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Safeguards</span></a>
							<ul class="menu-content">
								
									<li <?= ($currentPage == 'safeguards-dashboard') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/safeguards-dashboard"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Dashboard</span></a>
									</li>
								
									<li <?= ($currentPage == 'project-safeguards') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-safeguards"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Safeguards</span></a>
									</li>
								
								
								<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reviews</span></a>
									<ul class="menu-content">
																			
											<li <?= ($currentPage == 'document-approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/document-approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Documents</span></a>
											</li>
																		
									</ul>
								</li>
								
								
									<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Approvals</span></a>
										<ul class="menu-content">	
																		
												<li <?= ($currentPage == 'document-approvals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/document-approvals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Documents</span></a>
												</li>
																									
										</ul>
									</li>
								
								
									<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Rejected</span></a>
										<ul class="menu-content">	
																			
												<li <?= ($currentPage == 'document-approvals' && $option == 4) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/document-approvals?option=4"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Documents</span></a>
												</li>
																
										</ul>
									</li>
								
								
							</ul>
						</li>
					<?php } ?>

					<?php if (Yii::$app->user->can('access-complaints')) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Complaints</span></a>
							<ul class="menu-content">
								
									<li <?= ($currentPage == 'complaints') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaints"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Complaints</span></a>
									</li>
								
								
									<li <?= ($currentPage == 'complaints-assigned') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaints-assigned"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Assigned Complaints</span></a>
									</li>
								
								
									<li <?= ($currentPage == 'complaints-resolved') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaints-resolved"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Resolved Complaints</span></a>
									</li>
								
								
									<li <?= ($currentPage == 'complaints-closed') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaints-closed"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Closed Complaints</span></a>
									</li>
								
								
									<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
										<ul class="menu-content">	
																		
												<li <?= ($currentPage == 'complaint-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaint-types"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Complaint Types</span></a>
												</li>
											
											
												<li <?= ($currentPage == 'complaint-tiers') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaint-tiers"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Complaint Tiers</span></a>
												</li>
											
											
												<li <?= ($currentPage == 'complaint-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaint-status"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Complaint Status</span></a>
												</li>
											
											
												<li <?= ($currentPage == 'complaint-priorities') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaint-priorities"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Complaint Priorities</span></a>
												</li>
											
											
												<li <?= ($currentPage == 'complaint-channels') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/complaint-channels"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Complaint Channels</span></a>
												</li>														
										</ul>
									</li>
								
							</ul>
						</li>
					<?php } ?>
					<?php if (count(array_intersect($rights, [97, 99, 100, 101, 102])) > 0) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">LIPW</span></a>
							<ul class="menu-content">
								<?php if (in_array(97, $rights)) { ?>
									<li <?= ($currentPage == 'lipw-households') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-households"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Households</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(99, $rights)) { ?>
									<li <?= ($currentPage == 'lipw-master-roll') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-master-roll"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Master Roll</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(100, $rights)) { ?>
									<li <?= ($currentPage == 'lipw-payment-request') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-payment-request"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payment Request</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(101, $rights)) { ?>
									<li <?= ($currentPage == 'lipw-payment-request-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-payment-request-status"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payment Request Status</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(102, $rights)) { ?>
									<li <?= ($currentPage == 'lipw-payment-schedule-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/lipw-payment-schedule-status"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payment Schedule Status</span></a>
									</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
					<?php if (Yii::$app->user->can('access-monitoring')) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Monitoring</span></a>
							<ul class="menu-content">
								
									<li <?= ($currentRoute == 'result-indicators') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/result-indicators"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Result Indicators</span></a>
									</li>
								
								
									<li <?= ($currentRoute == 'reports/implementation-status-report') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/reports/implementation-status-report"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Implementation Status</span></a>
									</li>
								
								
									<li <?= ($currentRoute == 'reports/result-framework') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/result-framework"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Result Framework</span></a>
									</li>
								
							</ul>
						</li>
					<?php } ?>	
					<?php if (count(array_intersect($rights, [15, 54, 63, 19, 13, 116, 120])) > 0) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
							<ul class="menu-content">
								<?php if (in_array(15, $rights)) { ?>
									<li <?= ($currentPage == 'counties') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/counties"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Counties</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(54, $rights)) { ?>
									<li <?= ($currentPage == 'sub-counties') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/sub-counties"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Sub Counties</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(63, $rights)) { ?>
									<li <?= ($currentPage == 'wards') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/wards"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Wards</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(79, $rights)) { ?>
									<li <?= ($currentPage == 'sub-locations') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/sub-locations"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Villages</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(19, $rights)) { ?>
									<li <?= ($currentPage == 'departments') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/departments"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Departments</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(13, $rights)) { ?>
									<li <?= ($currentPage == 'company') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/company/update?id=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Company</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(116, $rights)) { ?>
									<li <?= ($currentPage == 'questionnaire-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/questionnaire-status"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Questionnaire Status</span></a>
									</li>
								<?php } ?>
								<?php if (in_array(120, $rights)) { ?>
									<li <?= ($currentRoute == 'document-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/document-types"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Document Types</span></a>
									</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
					<?php if (Yii::$app->user->can('access-security')) { ?>
						<li class=" nav-item"><a href="#"><i class="material-icons">person_outline</i><span class="menu-title" data-i18n="nav.project.main">Security & Admin</span></a>
							<ul class="menu-content">
								
									<li <?= ($currentPage == 'users') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/users"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Users</span></a>
									</li>
								
								
									<li <?= ($currentPage == 'userstatus') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/userstatus"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">User Status</span></a>
									</li>
								
								
									<li <?= ($currentPage == 'usergroups') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/usergroups"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">User Groups</span></a>
									</li>
								

                                
                                    <li <?= ($currentPage == 'pages') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/pages"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Module Pages</span></a>
                                    </li>
                               

                               
                                    <li <?= ($currentPage == 'user-group-rights') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/user-group-rights"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">User Group Rights</span></a>
                                    </li>
                               

                                <li <?= ($currentPage == 'auth-item') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/auth-item"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Permissions Setup</span></a>
                                </li>

                                <li <?= ($currentPage == 'auth-item-child') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/auth-item-child"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Role Permissions</span></a>
                                </li>

                                <li <?= ($currentPage == 'auth-item-type') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/auth-item-type"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Authentication Types Setup</span></a>
                                </li>



                                <li <?= ($currentPage == 'auth-assignment') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/auth-assignment"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Permissions Assignment</span></a>
                                </li>

							</ul>
						</li>
					<?php } ?>
					<!--<li class=" navigation-header"><span data-i18n="nav.category.support">Support</span><i class="material-icons nav-menu-icon" data-toggle="tooltip" data-placement="right" data-original-title="Support">more_horiz</i>
					</li>
					<li class="<?= ($currentRoute == 'site/support') ? 'active' : ''; ?> nav-item"><a href="<?= $baseUrl; ?>/site/support"><i class="material-icons">local_offer</i><span class="menu-title" data-i18n="nav.support_raise_support.main">Raise Support</span></a>
					</li>
					<li class="<?= ($currentRoute == 'site/documentation') ? 'active' : ''; ?> nav-item" <?= ($currentRoute == 'site/documentation') ? 'class="active"' : ''; ?>><a href="<?= $baseUrl; ?>/site/documentation"><i class="material-icons">format_size</i><span class="menu-title" data-i18n="nav.support_documentation.main">Documentation</span></a>
					</li>-->
			</ul>
		</div>
	</div>

	<!-- END: Main Menu-->
