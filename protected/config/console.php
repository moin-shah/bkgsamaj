<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'BKGS Portal Console',
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
    'components'=>array(
        'db'=>require(dirname(__FILE__).'/commandb.php'),
    ),
);
