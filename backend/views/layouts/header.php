<?php

$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;
?>
<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
		<div class="navbar-wrapper">
			<div class="navbar-header">
					<ul class="nav navbar-nav flex-row">
						<li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
						<li class="nav-item mr-auto"><a class="navbar-brand" href="/site/index">
									<h3 class="brand-text">KDRDIP</h3>
							</a></li>
						<li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
						<li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="material-icons mt-1">more_vert</i></a></li>
					</ul>
			</div>
			<div class="navbar-container content">
					<div class="collapse navbar-collapse" id="navbar-mobile">
						<ul class="nav navbar-nav mr-auto float-left">
							<!-- <li class="nav-item nav-link-search"><a class="nav-link d-none d-lg-block" href="#"><i class="material-icons search-icon">search</i>
										<input class="round form-control search-box" type="text" placeholder="Explore Modern Admin"><a class="nav-link dropdown-toggle search-bar-toggle d-lg-none d-m-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">search</i></a>
										<div class="dropdown-menu arrow"><a class="dropdown-item">
													<input class="round form-control" type="text" placeholder="Search Here"></a></div>
									</a></li> -->
							<li class="nav-item d-none d-lg-block d-none"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
							<li class="dropdown nav-item mega-dropdown d-lg-block d-none"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Kenya Development Response to Displacement Impacts Project</a>
					<!-- 				<ul class="mega-dropdown-menu dropdown-menu row">
										<li class="col-md-2">
											<h6 class="dropdown-menu-header text-uppercase mb-1"><i class="material-icons">list_alt</i> News</h6>
											<div id="mega-menu-carousel-example">
													<div><img class="rounded img-fluid mb-1" src="<?= $baseUrl; ?>/app-assets/images/slider/slider-2.png" alt="First slide"><a class="news-title mb-0 d-block" href="#">Poster Frame PSD</a>
														<p class="news-content"><span class="font-small-2">January 26, 2018</span></p>
													</div>
											</div>
										</li>
										<li class="col-md-3">
											<h6 class="dropdown-menu-header text-uppercase"><i class="material-icons">arrow_downward</i> Menu</h6>
											<ul>
													<li class="menu-list">
														<ul>
															<li><a class="dropdown-item" href="layout-fixed.html"><i class="material-icons">content_copy</i> Page layouts</a></li>
															<li><a class="dropdown-item" href="color-palette-primary.html"><i class="material-icons">colorize</i> Color palette</a></li>
															<li><a class="dropdown-item" href="layout-2-columns.html"><i class="material-icons">star_border</i> Starter kit</a></li>
															<li><a class="dropdown-item" href="changelog.html"><i class="material-icons">change_history</i> Change log</a></li>
															<li><a class="dropdown-item" href="https://pixinvent.ticksy.com/"><i class="material-icons">person_outline</i> Support center</a></li>
														</ul>
													</li>
											</ul>
										</li>
										<li class="col-md-3">
											<h6 class="dropdown-menu-header text-uppercase"><i class="material-icons">list</i>Accordion</h6>
											<div class="mt-1" id="accordionWrap" role="tablist" aria-multiselectable="true">
													<div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
														<div class="card-header p-0 pb-2 border-0" id="headingOne" role="tab"><a data-toggle="collapse" href="#accordionOne" aria-expanded="true" aria-controls="accordionOne">Accordion Item #1</a></div>
														<div class="card-collapse collapse show" id="accordionOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordionWrap" aria-expanded="true">
															<div class="card-content">
																	<p class="accordion-text text-small-3">Caramels dessert chocolate cake pastry jujubes bonbon. Jelly wafer jelly beans. Caramels chocolate cake liquorice cake wafer jelly beans croissant apple pie.</p>
															</div>
														</div>
														<div class="card-header p-0 pb-2 border-0" id="headingTwo" role="tab"><a class="collapsed" data-toggle="collapse" href="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Accordion Item #2</a></div>
														<div class="card-collapse collapse" id="accordionTwo" role="tabpanel" data-parent="#accordionWrap" aria-labelledby="headingTwo" aria-expanded="false">
															<div class="card-content">
																	<p class="accordion-text">Sugar plum bear claw oat cake chocolate jelly tiramisu dessert pie. Tiramisu macaroon muffin jelly marshmallow cake. Pastry oat cake chupa chups.</p>
															</div>
														</div>
														<div class="card-header p-0 pb-2 border-0" id="headingThree" role="tab"><a class="collapsed" data-toggle="collapse" href="#accordionThree" aria-expanded="false" aria-controls="accordionThree">Accordion Item #3</a></div>
														<div class="card-collapse collapse" id="accordionThree" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordionWrap" aria-expanded="false">
															<div class="card-content">
																	<p class="accordion-text">Candy cupcake sugar plum oat cake wafer marzipan jujubes lollipop macaroon. Cake dragée jujubes donut chocolate bar chocolate cake cupcake chocolate topping.</p>
															</div>
														</div>
													</div>
											</div>
										</li>
										<li class="col-md-4">
											<h6 class="dropdown-menu-header text-uppercase mb-1"><i class="material-icons">mail_outline</i> Contact Us</h6>
											<form class="form form-horizontal">
													<div class="form-body">
														<div class="form-group row">
															<label class="col-sm-3 form-control-label" for="inputName1">Name</label>
															<div class="col-sm-9">
																	<div class="position-relative has-icon-left">
																		<input class="form-control" type="text" id="inputName1" placeholder="John Doe">
																		<div class="form-control-position pl-1"><i class="material-icons">person_outline</i></div>
																	</div>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 form-control-label" for="inputEmail1">Email</label>
															<div class="col-sm-9">
																	<div class="position-relative has-icon-left">
																		<input class="form-control" type="email" id="inputEmail1" placeholder="john@example.com">
																		<div class="form-control-position pl-1"><i class="material-icons">mail_outline</i></div>
																	</div>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 form-control-label" for="inputMessage1">Message</label>
															<div class="col-sm-9">
																	<div class="position-relative has-icon-left">
																		<textarea class="form-control" id="inputMessage1" rows="2" placeholder="Simple Textarea"></textarea>
																		<div class="form-control-position pl-1"><i class="material-icons simple-textarea">chat_bubble_outline</i></div>
																	</div>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-12 mb-1">
																	<button class="btn btn-info float-right" type="button"><i class="material-icons">send</i> Send </button>
															</div>
														</div>
													</div>
											</form>
										</li>
									</ul> -->
							</li>
						</ul>
						<ul class="nav navbar-nav float-right">
							<!-- <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
									<div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-gb"></i> English</a><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a></div>
							</li> -->
							<!-- <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="material-icons">notifications_none</i><span class="badge badge-pill badge-danger badge-up badge-glow">5</span></a>
									<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
										<li class="dropdown-menu-header">
											<h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6><span class="notification-tag badge badge-danger float-right m-0">5 New</span>
										</li>
										<li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left align-self-center"><i class="material-icons icon-bg-circle bg-cyan">add_box</i></div>
														<div class="media-body">
															<h6 class="media-heading">You have new order!</h6>
															<p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left align-self-center"><i class="material-icons icon-bg-circle bg-red bg-darken-1">cloud_download</i></div>
														<div class="media-body">
															<h6 class="media-heading red darken-1">99% Server load</h6>
															<p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left align-self-center"><i class="material-icons icon-bg-circle bg-yellow bg-darken-3">warning</i></div>
														<div class="media-body">
															<h6 class="media-heading yellow darken-3">Warning notifixation</h6>
															<p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left align-self-center"><i class="material-icons icon-bg-circle bg-cyan">check_circle</i></div>
														<div class="media-body">
															<h6 class="media-heading">Complete the task</h6><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left align-self-center"><i class="material-icons icon-bg-circle bg-teal">insert_drive_file</i></div>
														<div class="media-body">
															<h6 class="media-heading">Generate monthly report</h6><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
														</div>
													</div>
											</a></li>
										<li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
									</ul>
							</li>
							<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="material-icons">mail_outline </i></a>
									<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
										<li class="dropdown-menu-header">
											<h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span></h6><span class="notification-tag badge badge-warning float-right m-0">4 New</span>
										</li>
										<li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?= $baseUrl; ?>/app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></div>
														<div class="media-body">
															<h6 class="media-heading">Margaret Govan</h6>
															<p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="<?= $baseUrl; ?>/app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>
														<div class="media-body">
															<h6 class="media-heading">Bret Lezama</h6>
															<p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?= $baseUrl; ?>/app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>
														<div class="media-body">
															<h6 class="media-heading">Carie Berra</h6>
															<p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time></small>
														</div>
													</div>
											</a><a href="javascript:void(0)">
													<div class="media">
														<div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="<?= $baseUrl; ?>/app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>
														<div class="media-body">
															<h6 class="media-heading">Eric Alsobrook</h6>
															<p class="notification-text font-small-3 text-muted">We have project party this saturday.</p><small>
																	<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time></small>
														</div>
													</div>
											</a></li>
										<li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
									</ul>
							</li> -->
							<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?= $user->FirstName .' '. $user->LastName; ?></span><span class="avatar avatar-online"><img src="<?= $baseUrl; ?>/app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="<?= $baseUrl; ?>/profile/view"><i class="material-icons">person_outline</i> Edit Profile</a>
<!-- 										<a class="dropdown-item" href="app-email.html"><i class="material-icons">mail_outline</i> My Inbox</a>
										<a class="dropdown-item" href="user-cards.html"><i class="material-icons">content_paste</i> Task</a>
										<a class="dropdown-item" href="app-chat.html"><i class="material-icons">chat_bubble_outline</i> Chats</a> -->
										<div class="dropdown-divider"></div><a class="dropdown-item" href="<?= $baseUrl; ?>/site/logout"><i class="material-icons">power_settings_new</i> Logout</a>
									</div>
							</li>
						</ul>
					</div>
			</div>
		</div>
	</nav>
	<!-- END: Header-->