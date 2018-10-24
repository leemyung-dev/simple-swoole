<?php

/**
 * Created by NetBeans.
 * User : liming <leemyung728@gmail.com>
 * Date : 2018-10-10
 * Time : 20:37:18
 */

namespace SimpleSwoole\Core;

use SimpleSwoole\Core\Message;
use SimpleSwoole\Libs\Input;

class Controller {

    /**
     * @var Swoole
     */
    public $swoole;

    /**
     * @var Request
     */
    public $request;

    /**
     * 配置信息
     * @var Config 
     */
    public $config;
    
    /**
     * token
     * @var token
     */
    public $token;

    /**
     * 用户ID
     * @var uid 
     */
    public $uid;

    public function __construct($swoole) {
        $this->request = $swoole->request;
        $this->config = $swoole->config;
        $this->swoole = $swoole;

        Input::setData($this->request);

        $this->token = $this->getToken('token');
    }

    public function success($data) {
        return Message::output(200, $data);
    }

    public function error($code) {
        return Message::output($code);
    }

    protected function getToken($key, $default = null) {
        if (!isset($this->request->header[$key])) {
            $val = $default;
        } else {
            $val = urldecode($this->request->header[$key]);
        }
        return $val;
    }

}
