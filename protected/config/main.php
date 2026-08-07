<?php
session_start();

set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('memory_limit', '-1');
date_default_timezone_set("Asia/Calcutta");

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'BKGS - Portal',
    'theme'=>'metrov1',
    'defaultController' => 'customerLead',
    'preload'=>array('log'),
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'ext.YiiMailer.YiiMailer',
    ),
    'modules'=>array(

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'welcome123',
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
    ),
    'components'=>array(
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
                '' => 'site/login',
                '<partner_slug:\w+>' => 'customerLead/dashboard',
                '<partner_slug:\w+>/myleads' => 'customerLead/admin',
                '<partner_slug:\w+>/<controller:\w+>/<action:\w+>/id/<id:\d+>' => '<controller>/<action>',
                '<partner_slug:\w+>/inviteuser' => 'site/inviteuser',
                '<partner_slug:\w+>/revenueestimator' => 'site/revenueestimator',
            ),
        ),
        'user'=>array(

            'allowAutoLogin'=>true,
            'stateKeyPrefix'=>'customkey',
        ),
        'session' => array (

            'sessionName' => 'custom_session_externacrm_id',
            'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'timeout' => 2592000,
        ),
        'db'=>require(dirname(__FILE__).'/commandb.php'),
        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                
            ),
        ),
    ),
    'params'=>array(
        //LATEST SMTP2GO
        'host'=>'mail.smtp2go.com',
        'host_plain'=>'mail.smtp2go.com',
        'host_username'=>'softwaresuggest.com',
        'host_password'=>'pBL5suHmDSwkcFCB',
        'host_port'=>'2525',
        'port'=>'2525',
        //LATEST SMTP2GO END
    ),
);
