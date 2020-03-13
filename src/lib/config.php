<?php
define("DS", "/");
define("APP_PATH", dirname(__FILE__, 2).DS.'app');
define("RESOURCE_PATH", APP_PATH.DS.'.res');
define("TEMPLATE_PATH", dirname(__FILE__).DS."cli".DS."templates");
define("CLI_PATHS", [
    'MIDDLEWARE' => ["template" => TEMPLATE_PATH.DS.'middleware.temp', "target" =>  APP_PATH.DS.'middleware'],
    'ROUTING'    => ["template" => TEMPLATE_PATH.DS.'routing.temp', "target" =>  APP_PATH.DS.'routing'],
    'SERVICE'    => ["template" => TEMPLATE_PATH.DS.'service.temp', "target" =>  APP_PATH.DS.'service'],
    'REPOSITORY' => ["template" => TEMPLATE_PATH.DS.'repo.temp', "target" =>  APP_PATH.DS.'repository'],
    'MODEL'      => ["template" => TEMPLATE_PATH.DS.'model.temp', "target" =>  APP_PATH.DS.'model'],
    'RESOURCE'   => ["template" => TEMPLATE_PATH.DS.'resource.temp', "target" =>  APP_PATH.DS.'resource'],
]);