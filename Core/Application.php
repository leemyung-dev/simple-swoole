<?php

/**
 * Created by NetBeans.
 * User : liming <leemyung728@gmail.com>
 * Date : 2018-10-9
 * Time : 19:56:02
 */

namespace SimpleSwoole\Core;

use Swoole\Http\Request;
use Swoole\Http\Server;
use Swoole\Http\Response;
use SimpleSwoole\Core\Route;

class Application {

    /**
     * number of worker processes
     *
     * @var int
     */
    private $numWorker = 4;

    /**
     * number of task worker process
     *
     * @var int
     */
    private $numTaskWorker = 8;

    /**
     * @var Server
     */
    public $server;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;
    
    
    public $config;

    public function run() {
        //初始化 Server信息
        $this->server = new Server('0.0.0.0', 9501, SWOOLE_PROCESS, SWOOLE_SOCK_ASYNC);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('managerStart', [$this, 'onManagerStart']);
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
//        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('start', [$this, 'onStart']);
        $this->server->set([
            'worker_num' => $this->numWorker,
            //'log_file' => '',
//            'daemonize' => true,
//            'task_worker_num' => $this->numTaskWorker,
        ]);

        //致命异常捕获方法
        register_shutdown_function([$this, 'handleFatal']);
        
        //Server 启动
        $this->server->start();
    }

    public function onStart(Server $server) {
        swoole_set_process_name('simple_swoole_master');
    }

    public function onManagerStart(Server $server) {
        swoole_set_process_name('simple_swoole_manager');
    }

    public function onWorkerStart(Server $server) {

        swoole_set_process_name('simple_swoole_worker');
    }

    public function onTask() {
        swoole_set_process_name('simple_swoole_task');
    }

    public function onRequest(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;

        //路由解析
        Route::dispatch($request, $response);

        //执行方法 controller->func()
        $result = Route::doAction($request, $response, $this);

        //信息 返回给客户端
        $response->header('content-type', 'application/json');
        $response->end(json_encode($result));
    }

    /**
     * 异常捕获
     */
    public function handleFatal() {
        $error = error_get_last();

        if (isset($error['type'])) {
            switch ($error['type']) {
                case E_ERROR :
                case E_PARSE :
                case E_USER_ERROR:
                case E_CORE_ERROR :
                case E_COMPILE_ERROR :
                    $message = $error['message'];
                    $file = $error['file'];
                    $line = $error['line'];
                    $log = "$message ($file:$line)\nStack trace:\n";
                    $trace = debug_backtrace();
                    foreach ($trace as $i => $t) {
                        if (!isset($t['file'])) {
                            $t['file'] = 'unknown';
                        }
                        if (!isset($t['line'])) {
                            $t['line'] = 0;
                        }
                        if (!isset($t['function'])) {
                            $t['function'] = 'unknown';
                        }
                        $log .= "#$i {$t['file']}({$t['line']}): ";
                        if (isset($t['object']) and is_object($t['object'])) {
                            $log .= get_class($t['object']) . '->';
                        }
                        $log .= "{$t['function']}()\n";
                    }

                    if (isset($this->request->server['request_uri'])) {
                        $log .= '[QUERY] ' . $this->request->server['request_uri'];
                    }
                    error_log($log . $this->request->server['request_uri']);
                    $this->response->status(500);
                    $this->response->header('content-type', 'application/json');
                    $this->response->end(json_encode(['code' => 500, 'message' => DEBUG ? $error['message'] : 'Server Error', 'data' => '']));
                default:
                    break;
            }
        }
    }

}
