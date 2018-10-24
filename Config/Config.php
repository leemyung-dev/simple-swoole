<?php

/**
 * Created by NetBeans.
 * User : liming <liming@wutiao.com>
 * Date : 2018-10-11
 * Time : 9:38:25
 */
return [
    'db' => [
        'master' => [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => '',
            'database' => 'db',
            'port' => 3306,
            'timeout' => 2,
            'charset' => 'utf8mb4',
//            'strict_type' => false, //开启严格模式，返回的字段将自动转为数字类型
//            'fetch_mode' => true, //开启fetch模式, 可与pdo一样使用fetch/fetchAll逐行或获取全部结果集(4.0版本以上)
        ],
        'slave' => [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => '',
            'database' => 'db',
            'port' => 3306,
            'timeout' => 2,
            'charset' => 'utf8mb4',
//            'strict_type' => false, //开启严格模式，返回的字段将自动转为数字类型
//            'fetch_mode' => true, //开启fetch模式, 可与pdo一样使用fetch/fetchAll逐行或获取全部结果集(4.0版本以上)
        ],
    ]
];
