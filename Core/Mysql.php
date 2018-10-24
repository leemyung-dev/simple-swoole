<?php

/**
 * Created by NetBeans.
 * User : liming <leemyung728@gmail.com>
 * Date : 2018-10-11
 * Time : 10:44:15
 */

namespace SimpleSwoole\Core;

use SimpleSwoole\Libs\Common;

class Mysql {

    public $db;

    public function __construct($key = 'db') {
        
    }

    public function connect() {
        //加载配置文件
        $config = Common::load();
        $db = new \Swoole\Coroutine\Mysql();

        //连接到数据库
        try {
            $db->connect($config['db']['master']);
        } catch (\Swoole\Mysql\Exception $ex) {
            //return $ex->getMessage();
            throw new \Swoole\ExitException($ex->getMessage());
        }

        return $db;
    }

    /**
     * 执行SQL语句
     *
     * @link https://wiki.swoole.com/wiki/page/596.html
     *
     * @param string $sql
     * @param double $timeout 超时时间，超时的话会断开MySQL连接，0表示不设置超时时间。
     *
     * @return array|bool  超时/出错返回 false，否则以数组形式返回查询结果
     */
    public function query($sql, $timeout = 0.0) {
        $db = $this->connect();
        
        //验证 是否已连接到数据库
        if (!empty($db->connected)) {
            $result = $db->query($sql);
        } else {
            //return $db->connect_error;
            throw new \Swoole\ExitException($db->connect_error);
        }

        return $result;
    }

    /**
     * use mysqlnd to escape  the string
     * use --enable-mysqlnd when compile
     *
     * @param string $str
     *
     * @return string
     */
    public function escape(string $str): string {
        
    }

    /**
     * start a new transaction
     * one link only one transaction, if already exist, then exception
     * function callback(\Swoole\Mysql $link, mixed $result) {}
     *
     */
    public function begin() {
        
    }

    /**
     * commit transaction
     * if not exist, then exception
     * function callback(\Swoole\Mysql $link, mixed $result) {}
     *
     */
    public function commit() {
        
    }

    /**
     * rollback transaction
     * if not exist, then exception
     * function callback(\Swoole\Mysql $link, mixed $result) {}
     *
     */
    public function rollback() {
        
    }

    /**
     * close the connection
     */
    public function close() {
        
    }

    /**
     * 延迟收包
     *
     * @param bool $bool
     */
    public function setDefer(bool $bool = true) {
        
    }

    /**
     * 向MySQL服务器发送SQL预处理请求。
     * prepare必须与execute配合使用。
     * 预处理请求成功后，调用execute方法向MySQL服务器发送数据参数。
     *
     * @param string $sql
     *
     * @return Statement
     */
    public function prepare(string $sql): Statement {
        
    }

}
