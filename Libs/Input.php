<?php

/**
 * Created by NetBeans.
 * User : liming <leemyung728@gmail.com>
 * Date : 2018-10-12
 * Time : 10:51:21
 */

namespace SimpleSwoole\Libs;

class Input {

    public static $clear_xss = true;
    public static $request;

    public static function setData($request) {
        self::$request = $request;
    }

    public static function setClearXss($flag = true) {
        self::$clear_xss = $flag;
    }

    private static function getValue($type) {
        switch (strtoupper($type)) {
            case 'POST':
                $value = self::$request->post;
                break;
            case 'GET':
                $value = self::$request->get;
                break;
            case 'COOKIE':
                $value = self::$request->cookie;
                break;
            case 'SESSION':
                $value = '';
                break;
            default:
                $value = self::$request->get;
                break;
        }

        return $value;
    }

    public static function getString($param, $default = null, $type = 'get') {
        $value = self::getValue($type);
        $tmp = isset($value[$param]) ? trim($value[$param]) : (is_array($default) ? $default[0] : $default);
        if (is_array($default) && !in_array($tmp, $default)) {
            return $default[0];
        }
        if (self::$clear_xss == false) {
            return $tmp;
        }
        return self::clear_xss($tmp);
    }

    public static function getInt($param, $default = 0, $type = 'get') {
        $value = self::getValue($type);
        $tmp = isset($value[$param]) ? intval($value[$param]) : (is_array($default) ? $default[0] : $default);
        if (is_array($default) && !in_array($tmp, $default)) {
            return $default[0];
        }
        return $tmp;
    }

    /**
     * 过滤xss函数
     * @staticvar type $_clean_xss_obj
     * @param type $string
     * @return type
     */
    public static function clear_xss($string) {
        static $_clean_xss_obj = null;
        if ($_clean_xss_obj === null) {
            // 生成配置对象
            $_clean_xss_config = \HTMLPurifier_Config::createDefault();
            // 以下就是配置：
            $_clean_xss_config->set('Core.Encoding', 'UTF-8');
            // 设置允许使用的HTML标签
            $_clean_xss_config->set('HTML.Allowed', 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
            // 设置允许出现的CSS样式属性
            $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
            // 设置a标签上是否允许使用target="_blank"
            $_clean_xss_config->set('HTML.TargetBlank', false);
            // 使用配置生成过滤用的对象
            $_clean_xss_obj = new \HTMLPurifier($_clean_xss_config);
        }
        // 过滤字符串
        return $_clean_xss_obj->purify($string);
    }

}
