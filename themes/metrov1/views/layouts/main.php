<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.8.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php $baseUrl = Yii::app()->baseUrl.'/themes/metrov1' ?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?=$baseUrl?>/assets/all.css" rel="stylesheet" type="text/css"/>
<!-- <link href="<?=$baseUrl?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/> -->
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<!-- <link href="<?=$baseUrl?>/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/> -->
<!-- <link id="style_color" href="<?=$baseUrl?>/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="<?=$baseUrl?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/> -->
<!-- <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/assets/global/plugins/select2/select2.css"/> -->
<link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="">

	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
	      <?php //include('sidebar.php'); ?>
		  <?php echo $content; ?>
	</div>
	<!-- END CONTAINER -->
	 <?php include('footer.php'); ?>
</body>
</html>
