simple-swoole

基于Swoole开发的，简单易懂的API框架，实现了Controller&Model封装。

安装方法：git clone 下来以后，在根目录运行 composer update 即可。

服务器 启动：php server.php

路由配置：
Core/Route.php dispatch方法里 $r->addRoute('GET', '/', 'index'); 添加路由即可。

目录说明：
App             = 项目控制器、模型存放
Config          = 项目配置类信息
Core            = 系统核心库，封装了Swoole
Libs            = 项目类存放
Logs            = 项目程序日志目录

实现功能：
基于fast-route实现了路由
基于Swoole实现了 Http Server
基于Swoole协程Mysql库，实现了协程Mysql模型
实现类：Input = 获取参数类， Message = 信息提示类

进程出现异常导致退出，也会捕捉到错误，并且返回给客户端,
程序逻辑错误异常，也可以捕捉到，并且返回给客户端，
让客户端永远能正常收到服务端的返回信息。


另外实现了，基于Swoole Process，读取差大日志文件功能
使用方式：php fileread.php