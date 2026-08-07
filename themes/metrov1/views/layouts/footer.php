<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=$baseUrl?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script type="text/javascript" src="<?=$baseUrl?>/assets/yii-js/jquery.ba-bbq.js"></script>

<script src="<?=$baseUrl?>/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?=$baseUrl?>/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="http://d1myhw8pp24x4f.cloudfront.net/newdndAssets/bootstrap.min.js"></script>-->

<script src="<?=$baseUrl?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!--<script src="<?=$baseUrl?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->


<!-- END CORE PLUGINS -->
<script src="<?=$baseUrl?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$baseUrl?>/assets/js/jquery.multiselect.js"></script>
<!--<script type="text/javascript" src="<?=$baseUrl?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script> -->
<!--<script type="text/javascript" src="<?=$baseUrl?>/assets/global/plugins/select2/select2.min.js"></script>-->
<script type="text/javascript" src="<?=$baseUrl?>/assets/js/jquery.daterangepicker.js"></script> <!-- 26-05-2015 -->

<script type="text/javascript" src="<?=$baseUrl?>/assets/js/bootstrap-editable.min.js"></script>

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script> 01-06-2015-->

<script>
jQuery(document).ready(function() {   
// initiate layout and plugins
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features

});
</script>

<script type="text/javascript">
	$(window).load(function(){
		if ($('body').hasClass('lead-admin-panel')) {
			return;
		}
		$('body').addClass('page-sidebar-closed');
		$('.page-sidebar-menu').addClass('page-sidebar-menu-closed');
	});
</script>