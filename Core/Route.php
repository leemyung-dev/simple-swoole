<?php

/**
 * Created by NetBeans.
 * User : liming <leemyung728@gmail.com>
 * Date : 2018-10-10
 * Time : 10:16:16
 */

namespace SimpleSwoole\Core;

use SimpleSwoole\Core\Message;

class Route {

    static $route = [];

    /**
     * 路由解析
     * @param type $request
     * @param type $response
     * @return type
     */
    public static function dispatch($request, $response) {
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', 'index');
            $r->addRoute('GET', '/index/view', 'view');
        });

        // 获取请求的方法和 URI
        $httpMethod = $request->server['request_method'];
        $uri = $request->server['request_uri'];

        // 去除查询字符串( ? 后面的内容) 和 解码 URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        //获取控制器名称
        $controller = ltrim($uri, '/');
        if (false !== $pos = strpos($controller, '/')) {
            $controller = substr($controller, 0, $pos);
        }

        //初始化路由信息
        if (self::$route) {
            self::$route = [];
        }

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found 没找到对应的方法
                $response->status(404);
                self::$route['errorCode'] = 404;
                self::$route['errorMessage'] = Message::get(404);
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                // ... 405 Method Not Allowed  方法不允许
                $response->status(405);
                self::$route['errorCode'] = 405;
                self::$route['errorMessage'] = Message::get(405);
                break;
            case \FastRoute\Dispatcher::FOUND: // 找到对应的方法
                // ... call $handler with $vars // 调用处理函数
                self::$route['controller'] = ucfirst($controller);
                self::$route['action'] = $routeInfo[1];
                self::$route['params'] = $request->{strtolower($httpMethod)};
                break;
        }

        return self::$route;
    }

    /**
     * 执行方法
     * @param type $request
     * @param type $response
     * @param type $swoole
     * @return type
     * @throws \Exception
     */
    public static function doAction($request, $response, $swoole) {
        try {
            //如果解析失败，则返回错误信息
            if (!empty(self::$route['errorCode'])) {
                return ['code' => self::$route['errorCode'], 'message' => self::$route['errorMessage'], 'data' => false];
            }

            $controller_class = '\\SimpleSwoole\\Apps\\Controllers\\' . self::$route['controller'] . 'Controller';
            $controller_file = WEBPATH . '/Apps/Controllers/' . self::$route['controller'] . 'Controller.php';

            //如果第一次就会载入，第二次就不需要重新载入
            if (class_exists($controller_class, false)) {
                goto do_action;
            } else {
                if (is_file($controller_file)) {
                    require_once $controller_file;
                    goto do_action;
                }
            }
            var_export(self::$route);
            $response->status(404);
            throw new \Swoole\ExitException("Not Found Controller : " . self::$route['controller'], 404);

            do_action:
            $controller = new $controller_class($swoole);
            if (!method_exists($controller, self::$route['action'])) {
                $response->status(404);
                throw new \Swoole\ExitException("Not Found Method : " . self::$route['action'] . "{URL: {$request->server['request_uri']}}", 404);
            }

//        //\Swoole\Runtime::enableCoroutine();
//        //$chan = new \Swoole\Channel(1024 * 256);
//        
//        $result = [];
//        //执行方法
//        go(function () use ($controller, $chan, &$result) {
//            try {
//                $result = $controller->{self::$route['action']}(self::$route['params']);
//            } catch (\Swoole\ExitException $e) {
//                assert($e->getStatus() === 1);
//                assert($e->getFlags() === SWOOLE_EXIT_IN_COROUTINE);
//                $result = ['code' => 404, 'message' => $e->getMessage(), 'data' => ''];
//            }
//
//            //$chan->push($result);
//        });
//        //$result = $chan->pop();
//
//        //如果没有拿到返回数据，则拼写一个，返回给客户端正常格式的数据
//        if(empty($result)) {
//            $result = ['code' => 500, 'message' => "Server Error", 'data' => ''];
//        }



            $result = $controller->{self::$route['action']}(self::$route['params']);
        } catch (\Swoole\ExitException $e) {
            assert($e->getStatus() === 1);
            assert($e->getFlags() === SWOOLE_EXIT_IN_COROUTINE);
            $result = ['code' => $e->getCode(), 'message' => $e->getMessage(), 'data' => false];
        }

        return $result;
    }

}
