<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-10
 * Time : 13:55:14
 */

namespace SimpleSwoole\Core;

class Message {

    static $data = [
        200 => 'Success',
        
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        
        
        
        600 => '该用户不存在',
        601 => '',
        602 => '',
        603 => '',
        604 => '',
        
        
    ];

    /**
     * 根据错误码 获取错误信息
     * @param type $code
     * @return type
     */
    public static function get($code) {
        return isset(self::$data[$code]) ? self::$data[$code] : 'no code';
    }

    /**
     * 往客户端 输出信息
     * @param type $code
     * @param type $message
     * @param type $data
     * @return type
     */
    public static function output($code, $data = null) {
        return ['code' => $code, 'message' => self::get($code), 'data' => $data];
    }

}
