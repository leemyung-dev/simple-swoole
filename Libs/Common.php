<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-11
 * Time : 14:59:14
 */

namespace SimpleSwoole\Libs;

class Common {

    static $config;

    public static function load() {
        if (empty(self::$config)) {
            //加载配置文件
            $filename = WEBPATH . '/Config/Config.php';
            if (is_file($filename)) {
                self::$config = include_once $filename;
            }
        }

        return self::$config;
    }

    /**
     * +------------------------------------------------------------------------------
     * 获取客户端IP地址
     * +------------------------------------------------------------------------------
     */
    public static function getClientIp() {

        $ip = Input::getString('_ip');
        if ($ip) {
            return $ip;
        }

        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";

        if (false !== strpos($ip, ',')) {
            $ipsArray = explode(',', $ip);
            $ip = reset($ipsArray);
        }

        return $ip;
    }

}
