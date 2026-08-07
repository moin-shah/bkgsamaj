<?php $baseUrl = Yii::app()->baseUrl.'/themes/metrov1' ?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?=$baseUrl?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$baseUrl?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?=$baseUrl?>/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>

<script src="<?=$baseUrl?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?=$baseUrl?>/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$baseUrl?>/assets/js/jquery.multifile.js"></script>  <!-- 05-05-2015 -->
<?php echo $content; ?>
<script>
jQuery(document).ready(function() {   
// initiate layout and plugins
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
});
</script>
