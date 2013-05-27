<?php
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('_DEBUG') or define('_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once(dirname(__FILE__).'/../yii/framework/YiiBase.php'); //Your own yii base here
require_once(dirname(__FILE__).'/protected/Yii.php');
require_once(dirname(__FILE__).'/protected/PDWebApplication.php');

/**
 * return the application singleton
 * @return PDWebApplication
 */
function app() {
    return Yii::app();
}

/**
 * return the current web user
 * @return CWebUser
 */
function user() {
    return app()->user;
}

/**
 * whether the user is logged in
 * @return boolean 
 */
function logged_in() {
    return !user()->isGuest;
}

function onDebug() {
    return _DEBUG;
}

function brp($errorObj = null) {
    $dump = array('CVarDumper','dumpAsString');
    if(is_callable($dump)) {
        throw new Exception(call_user_func_array($dump,array($errorObj,10)));
        return;
    }
    throw new Exception(print_r($errorObj,true));
}

//Yii::createWebApplication(dirname(__FILE__).'/protected/config/main_conf.php')->run();
Yii::createApplication(
    'PDWebApplication',
    dirname(__FILE__).'/protected/config/main_conf.php'
)->run();


