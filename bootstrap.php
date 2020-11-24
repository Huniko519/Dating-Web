<?php
error_reporting(0);
// error_reporting(1);
// ini_set('display_startup_errors', true);
// ini_set('display_errors', true);

@set_time_limit(0);
@clearstatcache();
date_default_timezone_set('UTC');
ini_set('date.timezone', 'UTC');
header("Connection: Keep-alive");
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
ini_set('memory_limit', -1);
$_DS       = DIRECTORY_SEPARATOR;
$_BASEPATH = realpath(dirname(__FILE__)) . $_DS;
require $_BASEPATH . 'config.php';
$_CONTROLLERS   = $_BASEPATH . 'controllers' . $_DS;
$_LIBS          = $_BASEPATH . 'lib' . $_DS;
$_REQUESTS      = $_BASEPATH . 'requests' . $_DS;
$_AJAX          = $_REQUESTS . 'ajax' . $_DS;
$_WORKER        = $_REQUESTS . 'worker' . $_DS;
$_ENDPOINT_PATH = $_BASEPATH . 'endpoint' . $_DS . $endpoint_v . $_DS;
$_UPLOAD        = $_BASEPATH . 'upload' . $_DS;
$_CACHE         = $_BASEPATH . 'cache' . $_DS;
require_once $_LIBS . 'vendor' . $_DS . 'autoload.php';
require $_LIBS . 'db.php';
require $_LIBS . 'cache.php';
require $_LIBS . 'imagethumbnail.php';
require $_LIBS . 'theme.php';
require_once $_LIBS . 'webtopay.php';
require $_BASEPATH . 'core.php';
require $_LIBS . 'dataset.php';
//if( $config->spam_warning == '1' ) {
//    require_once $_LIBS . 'opinion.php';
//    $op = new Opinion();
//    $op->addToIndex($_LIBS . '/opinion/rt-polarity.neg', 'neg');
//    $op->addToIndex($_LIBS . '/opinion/rt-polarity.pos', 'pos');
//}
//var_dump(IsUserSpammer(1));
//exit();