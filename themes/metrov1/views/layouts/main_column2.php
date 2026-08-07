<?php 
$version = '5.8'; 
$controller = Yii::app()->controller->id;
$action     = Yii::app()->controller->action->id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="robots" content="noindex, nofollow" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<?php $baseUrl = Yii::app()->baseUrl . '/themes/metrov1' ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<link href="<?= $baseUrl ?>/assets/all.css" rel="stylesheet" type="text/css" />
	<link href="<?= $baseUrl ?>/assets/css/lead_portal.css?v=<?=$version?>" rel="stylesheet" type="text/css" />
	<link href="<?=$baseUrl?>/assets/css/newdesign_style.css?v=<?=$version?>" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="<?=Yii::app()->baseUrl?>/favicon.ico">
	<link href="<?= $baseUrl ?>/assets/css/dashboard.css?v=<?=$version?>" rel="stylesheet" type="text/css" />
	<link href="<?= $baseUrl ?>/assets/css/table_view.css?v=<?=$version?>" rel="stylesheet" type="text/css" />
	<script src="<?= $baseUrl ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?= $baseUrl ?>/assets/js/jquery.multifile.js"></script>
	<script type="text/javascript" src="<?= $baseUrl ?>/assets/js/jquery.yiiactiveform.js"></script>
	<script type="text/javascript" src="<?= $baseUrl ?>/assets/js/jquery.yii.js"></script>
	<script type="text/javascript" src="<?= $baseUrl ?>/assets/js/select_2.js"></script>
	<script type="text/javascript" src="<?=$baseUrl?>/assets/js/chosen.jquery.js" ></script>
	

	<!-- datepicker -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<?php Yii::app()->clientScript->scriptMap = array(
		'jquery.yiiactiveform.js' => false,
		'jquery.daterangepicker.js' => false,
		'jquery-ui.min.js' => false,
		'bootstrap-editable.js' => false,
		'jquery.yii.js' => false,
	); ?>
</head>
<body class="lead_portal lead-admin-panel page-quick-sidebar-over-content page-sidebar-closed">
	<div class="clearfix">
	</div>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<div class="page-logo">
				<a class="logo_link" href="<?php echo Yii::app()->createAbsoluteUrl('customerLead/admin'); ?>">
					<img src="/../../../images/logo/bkgs-logo.png" width="30" height="30" alt="SaasWorthy-logo" class="small-logo" />
					<img src="/../../../images/logo/bkgs-logo.png" alt="SaasWorthy-logo" width="150" height="34" class="logo-default" />
				</a>
			</div>
			<ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false"
				data-auto-scroll="true" data-slide-speed="200">
				<li class="<?= ($controller == 'customerLead' && $action == 'dashboard') ? 'active' : '' ?>">
					<a href="<?= Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/')); ?>" data-title="Lead Overview">
						<i class="dashboardi"></i>
						<span class="title">Lead Overview</span>
					</a>
				</li>
				<li class="<?= ($controller == 'customerLead' && $action == 'admin') ? 'active' : '' ?>">
					<a href="<?= Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/myleads')); ?>" data-title="My Leads">
						<i class="lead_i"></i>
						<span class="title">My Leads</span>
					</a>
				</li>
                <?php if (Yii::app()->user->is_crm_admin == 1) { ?>
				<li class="<?= ($controller == 'site' && $action == 'inviteuser') ? 'active' : '' ?>">
					<a href="<?= Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/inviteuser')); ?>" data-title="Invite Users">
						<i class="inviteuser_i"></i>
						<span class="title">Invite Users</span>
					</a>
				</li>
                <?php } ?>
                <?php if (Yii::app()->user->partner_source == 'Zenstack') { ?>
				<li class="<?= ($controller == 'site' && $action == 'revenueestimator') ? 'active' : '' ?>">
					<a href="<?= Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/revenueestimator')); ?>" data-title="Revenue Estimator">
						<i class="revenuebycategory_i"></i>
						<span class="title">Revenue Estimator</span>
					</a>
				</li>
				<?php } ?>
				<li class="sidebar-nav-logout">
					<a href="<?= Yii::app()->createAbsoluteUrl('site/logout'); ?>" data-title="Logout">
						<i class="glyphicon glyphicon-log-out"></i>
						<span class="title">Logout</span>
					</a>
				</li>
				<li class="sidebar-toggler-wrapper">
					<span class="pwrdby">Powered by BKGS</span>
					<div class="sidebar-toggler"></div>
				</li>
			</ul>
			<script>
			(function () {
				try {
					var key = 'lead_admin_sidebar_collapsed';
					/* Default: closed. Only explicit '0' means user chose expanded sidebar. */
					var wantOpen = localStorage.getItem(key) === '0';
					if (wantOpen) {
						document.body.classList.remove('page-sidebar-closed');
					} else {
						document.body.classList.add('page-sidebar-closed');
					}
					var menu = document.querySelector('.page-sidebar .page-sidebar-menu');
					if (menu) {
						if (wantOpen) {
							menu.classList.remove('page-sidebar-menu-closed');
						} else {
							menu.classList.add('page-sidebar-menu-closed');
						}
					}
				} catch (e) {}
			})();
			</script>
		</div>
	</div>
	<div class="page-container lead-admin-page-container">
		<div class="page-content-wrapper">
			<div class="page-content lead-admin-page-content">
				<div class="page-header navbar lead-admin-topbar">
					<div class="page-header-inner">
						<div class="username username-hide-on-mobile"> </div>
						<div class="user-details-wrapper">
							<div class="user-avatar">
								<span><?php $n = trim('moin'); echo $n !== '' ? mb_strtoupper(mb_substr($n, 0, 1, 'UTF-8')) : ''; ?></span>
							</div>
							<div class="user-details">
								<h4 class="name"><?php echo 'moin' ?></h4>
							</div>
						</div>
					</div>
				</div>
				<?php echo $content; ?>
			</div>
		</div>
	</div>
	<?php include('footer.php'); ?>
	<script>
	(function ($) {
		var LS_KEY = 'lead_admin_sidebar_collapsed';
		function applySidebarPreference() {
			try {
				var wantOpen = localStorage.getItem(LS_KEY) === '0';
				if (wantOpen) {
					$('body').removeClass('page-sidebar-closed');
					$('.page-sidebar-menu').removeClass('page-sidebar-menu-closed');
				} else {
					$('body').addClass('page-sidebar-closed');
					$('.page-sidebar-menu').addClass('page-sidebar-menu-closed');
				}
				if ($.cookie) {
					$.cookie('sidebar_closed', wantOpen ? '0' : '1', { path: '/' });
				}
			} catch (e) {}
			$('.page-sidebar-menu').css('display', 'block');
		}
		function persistSidebarFromBody() {
			try {
				var wantOpen = !$('body').hasClass('page-sidebar-closed');
				localStorage.setItem(LS_KEY, wantOpen ? '0' : '1');
				if ($.cookie) {
					$.cookie('sidebar_closed', wantOpen ? '0' : '1', { path: '/' });
				}
			} catch (e) {}
		}
		$(document).on('click', '.sidebar-toggler', function () {
			window.setTimeout(persistSidebarFromBody, 0);
		});
		$(function () {
			applySidebarPreference();
		});
		$(window).on('load', function () {
			if ($('body').hasClass('lead-admin-panel')) {
				applySidebarPreference();
			}
		});
	})(jQuery);
	</script>
</body>
</html>