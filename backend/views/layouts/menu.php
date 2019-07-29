<?php
$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;

$currentPage = Yii::$app->controller->id; 
?>

<!-- BEGIN: Main Menu-->

<div class="main-menu material-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
		<div class="user-profile">
			<div class="user-info text-center pb-2"><img class="user-img img-fluid rounded-circle w-25 mt-2" src="<?= $baseUrl; ?>/app-assets/images/portrait/medium/avatar-m-1.png" alt="" />
					<div class="name-wrapper d-block dropdown mt-1"><a class="white dropdown-toggle" id="user-account" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="user-name"><?= $user->FirstName .' '. $user->LastName; ?></span></a>
						<!-- <div class="text-light">Admin</div> -->
						<div class="dropdown-menu arrow" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item"><i class="material-icons align-middle mr-1">person</i><span class="align-middle">Profile</span></a><a class="dropdown-item"><i class="material-icons align-middle mr-1">message</i><span class="align-middle">Messages</span></a><a class="dropdown-item"><i class="material-icons align-middle mr-1">attach_money</i><span class="align-middle">Balance</span></a><a class="dropdown-item"><i class="material-icons align-middle mr-1">settings</i><span class="align-middle">Settings</span></a><a class="dropdown-item" href="<?= $baseUrl; ?>/site/logout"><i class="material-icons align-middle mr-1">power_settings_new</i><span class="align-middle" >Log Out</span></a></div>
					</div>
			</div>
		</div>
		<div class="main-menu-content">
			<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
					<li <?= ($currentPage == 'site') ? 'class="active"' : ''; ?> class=" nav-item"><a href="<?= $baseUrl;?>/site"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">work_outline</i><span class="menu-title" data-i18n="nav.project.main">Predictions</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'predictions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/predictions"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Prediction</span></a>
							</li>
							<li <?= ($currentPage == 'regions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/regions"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Regions</span></a>
							</li>
							<li <?= ($currentPage == 'leagues') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/leagues"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Leagues</span></a>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">account_balance</i><span class="menu-title" data-i18n="nav.project.main">Payments</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'payments') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/payments"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Payments</span></a>
							</li>
							<li <?= ($currentPage == 'mpesatransactions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/mpesatransactions"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Transactions</span></a>
							</li>
							<li <?= ($currentPage == 'paymentmethods') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/paymentmethods"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Payment Methods</span></a>
							</li>
							<li <?= ($currentPage == 'transactionstatus') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/transactionstatus"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Transaction Status</span></a>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">people_outline</i><span class="menu-title" data-i18n="nav.project.main">Members</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'profiles') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/profiles"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Profiles</span></a>
							</li>
							<li <?= ($currentPage == 'profilestatus') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/profilestatus"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Status</span></a>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">grid_on</i><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
						<ul class="menu-content">
							<li <?= ($currentPage == 'plans') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/plans"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Plans</span></a>
							</li>
							<li <?= ($currentPage == 'benefits') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/benefits"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Benefits</span></a>
							</li>
							<li <?= ($currentPage == 'planoptions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/planoptions"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Plan Options</span></a>
							</li>
						</ul>
					</li>
					<li class=" nav-item"><a href="#"><i class="material-icons">person_outline</i><span class="menu-title" data-i18n="nav.project.main">Security</span></a>
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
					<li class=" nav-item"><a href=""><i class="material-icons">local_offer</i><span class="menu-title" data-i18n="nav.support_raise_support.main">Raise Support</span></a>
					</li>
					<li class=" nav-item"><a href=""><i class="material-icons">format_size</i><span class="menu-title" data-i18n="nav.support_documentation.main">Documentation</span></a>
					</li>
			</ul>
		</div>
	</div>

	<!-- END: Main Menu-->
