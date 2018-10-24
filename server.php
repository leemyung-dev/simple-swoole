<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-9
 * Time : 19:27:05
 */

$error_reporting = true;
if ($error_reporting === false) {
    ini_set("display_errors", "off");
    error_reporting(0);
} else {
    ini_set("display_errors", "on");
    error_reporting(E_ALL);
}

define('WEBPATH', __DIR__);
define('DEBUG', true);

include_once __DIR__ . '/vendor/autoload.php';

use SimpleSwoole\Core\Application;

$app = new Application();
$app->run();


