<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$baseUrl = Yii::$app->request->baseUrl;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
	<?php $this->registerCsrfMetaTags() ?>
	<?= Html::csrfMetaTags() ?>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="Tafutaa Market Place">
	<meta name="keywords" content="Tafutaa Market Place">
	<meta name="author" content="Tafutaa">
	<title><?= Html::encode($this->title) ?></title>
	<link rel="apple-touch-icon" href="<?= $baseUrl; ?>/app-assets/images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?= $baseUrl; ?>/app-assets/images/ico/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<?php $this->head() ?>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<?php
if (Yii::$app->user->isGuest) { ?>
	<body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout 1-column   blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
	<?php
} else { ?>
<body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php } ?>
	<?php $this->beginBody() ?>
	<!-- BEGIN: Header-->
	<?= (!Yii::$app->user->isGuest) ? $this->render('header') : ''; ?>
	<!-- END: Header-->

	<!-- BEGIN: Main Menu-->
	<?= (!Yii::$app->user->isGuest) ? $this->render('menu') : ''; ?>
	<!-- END: Main Menu-->

	<!-- BEGIN: Content-->
	<div class="app-content content">
		<div class="content-header row">
		</div>
		<div class="content-wrapper">
			<div class="content-body">
		
				<?= $content ?>
		
			</div>
		</div>
	</div>
	<!-- END: Content-->

	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>

	<!-- BEGIN: Footer-->
	<?= (!Yii::$app->user->isGuest) ? $this->render('footer') : ''; ?>
	<!-- END: Footer-->
	<?php $this->endBody() ?>
</body>
<!-- END: Body-->

</html>
<?php $this->endPage() ?>
