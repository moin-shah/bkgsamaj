<?php
//include('../maintance.php');
//include '../index.php';
// change the following paths if necessary
// $yii='/usr/share/nginx/html/frmwork/framework/yii.php';
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if(isset($_SERVER['HTTPS'])){
        define('PROTOCOL',"https://");
}else{
        define('PROTOCOL',"http://");
}
require_once($yii);
Yii::createWebApplication($config)->run();
