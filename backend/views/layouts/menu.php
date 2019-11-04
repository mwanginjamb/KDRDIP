<?php
$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;

$currentPage = Yii::$app->controller->id;
$currentRoute = trim(Yii::$app->controller->module->requestedRoute);
$option = isset($_GET['option']) ? $_GET['option'] : '';

// echo $currentRoute; exit;
/* print '<pre>';
print_r(Yii::$app->controller); exit; */
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
					<li <?= ($currentPage == 'site') ? 'class="active"' : ''; ?> class=" nav-item"><a href="<?= $baseUrl;?>/site"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">account_balance</i><span class="menu-title" data-i18n="nav.project.main">Finance</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'accounts') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/accounts"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Chart of Accounts</span></a>
							</li>
							<li <?= ($currentPage == 'bank-accounts') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/bank-accounts"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Bank Accounts</span></a>
							</li>
							<li <?= ($currentPage == 'fixed-assets') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/fixed-assets"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Fixed Assets</span></a>
							</li>
							<li <?= ($currentPage == 'payments') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payments"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payments</span></a>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reports</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'productcategory') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/productcategory"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Item Categories</span></a>
									</li>									
									<li <?= ($currentPage == 'supplier-category') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/supplier-category"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Categories</span></a>
									</li>									
								</ul>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
								<ul class="menu-content">		
									<li <?= ($currentPage == 'banks') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/banks"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Banks</span></a>
									</li>							
									<li <?= ($currentPage == 'account-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/account-types"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Account Types</span></a>
									</li>
									<li <?= ($currentPage == 'payment-methods') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payment-methods"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payment Methods</span></a>
									</li>								
								</ul>
							</li>							
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">account_balance</i><span class="menu-title" data-i18n="nav.project.main">Procurement</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'product') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/product"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Items</span></a>
							</li>							
							<li <?= ($currentPage == 'suppliers') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/suppliers"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Suppliers</span></a>
							</li>							
							<li <?= ($currentPage == 'quotation') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/quotation"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotation</span></a>
							</li>
							<li <?= ($currentPage == 'purchases') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/purchases"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
							</li>	
							<li <?= ($currentPage == 'deliveries') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/deliveries"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Deliveries</span></a>
							</li>						
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reviews</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'qapprovals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/qapprovals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotations</span></a>
									</li>
									<li <?= ($currentPage == 'papprovals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/papprovals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
									</li>
									<li <?= ($currentPage == 'approvals' && $option == 1) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/approvals?option=1"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisitions</span></a>
									</li>									
								</ul>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Approvals</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'qapprovals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/qapprovals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Quotations</span></a>
									</li>
									<li <?= ($currentPage == 'papprovals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/papprovals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Purchases</span></a>
									</li>	
									<li <?= ($currentPage == 'approvals' && $option == 2) ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/approvals?option=2"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisitions</span></a>
									</li>									
								</ul>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Stores</span></a>
								<ul class="menu-content">		
									<li <?= ($currentPage == 'stores') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stores"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stores</span></a>
									</li>							
									<li <?= ($currentPage == 'requisition') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/requisition"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Requisition</span></a>
									</li>									
									<li <?= ($currentPage == 'store-issues') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/store-issues"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Store Issues</span></a>
									</li>	
									<li <?= ($currentPage == 'stock-take') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/stock-take"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Stock Take</span></a>
									</li>								
								</ul>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reports</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'productcategory') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/productcategory"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Item Categories</span></a>
									</li>									
									<li <?= ($currentPage == 'supplier-category') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/supplier-category"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Categories</span></a>
									</li>									
								</ul>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'productcategory') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/productcategory"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Item Categories</span></a>
									</li>									
									<li <?= ($currentPage == 'supplier-category') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/supplier-category"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Categories</span></a>
									</li>									
								</ul>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">work_outline</i><span class="menu-title" data-i18n="nav.project.main">Project  Management</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'projects') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/projects"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Projects</span></a>
							</li>
							<li <?= ($currentPage == 'components') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/components"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Components</span></a>
							</li>						
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Reports</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'productcategory') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/productcategory"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Item Categories</span></a>
									</li>									
									<li <?= ($currentPage == 'supplier-category') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/supplier-category"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Supplier Categories</span></a>
									</li>									
								</ul>
							</li>
							<li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
								<ul class="menu-content">									
									<li <?= ($currentPage == 'funding-sources') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/funding-sources"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Funding Sources</span></a>
									</li>
									<li <?= ($currentPage == 'project-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-status"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Status</span></a>
									</li>
									<li <?= ($currentPage == 'risk-rating') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/risk-rating"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Risk Rating</span></a>
									</li>
									<li <?= ($currentPage == 'project-roles') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-roles"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Roles</span></a>
									</li>
									<li <?= ($currentPage == 'project-units') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/project-units"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Project Units</span></a>								
								</ul>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Human Resources</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'employees') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/employees"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Employees</span></a>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'counties') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/counties"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Counties</span></a>
							</li>
							<li <?= ($currentPage == 'sub-counties') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/sub-counties"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Sub Counties</span></a>
							</li>
							<li <?= ($currentPage == 'wards') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/wards"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Wards</span></a>
							</li>
							<li <?= ($currentPage == 'departments') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/departments"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Departments</span></a>
							</li>							
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">person_outline</i><span class="menu-title" data-i18n="nav.project.main">Security & Admin</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'users') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/users"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Users</span></a>
							</li>
							<li <?= ($currentPage == 'userstatus') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/userstatus"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">User Status</span></a>
							</li>
							<li <?= ($currentPage == 'usergroups') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/usergroups"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">User Groups</span></a>
							</li>
						</ul>
					</li>
					<li class=" navigation-header"><span data-i18n="nav.category.support">Support</span><i class="material-icons nav-menu-icon" data-toggle="tooltip" data-placement="right" data-original-title="Support">more_horiz</i>
					</li>
					<li class="<?= ($currentRoute == 'site/support') ? 'active' : ''; ?> nav-item"><a href="<?= $baseUrl; ?>/site/support"><i class="material-icons">local_offer</i><span class="menu-title" data-i18n="nav.support_raise_support.main">Raise Support</span></a>
					</li>
					<li class="<?= ($currentRoute == 'site/documentation') ? 'active' : ''; ?> nav-item" <?= ($currentRoute == 'site/documentation') ? 'class="active"' : ''; ?>><a href="<?= $baseUrl; ?>/site/documentation"><i class="material-icons">format_size</i><span class="menu-title" data-i18n="nav.support_documentation.main">Documentation</span></a>
					</li>
			</ul>
		</div>
	</div>

	<!-- END: Main Menu-->
