simple-swoole<br>
<br>
基于Swoole开发的，简单易懂的API框架，实现了Controller&Model封装。<br>
<br>
安装方法：git clone 下来以后，在根目录运行 composer update 即可。<br>
<br>
服务器 启动：php server.php<br>
<br>
路由配置：<br>
Core/Route.php dispatch方法里 $r->addRoute('GET', '/', 'index'); 添加路由即可。<br>

目录说明：<br>
App             = 项目控制器、模型存放<br>
Config          = 项目配置类信息<br>
Core            = 系统核心库，封装了Swoole<br>
Libs            = 项目类存放<br>
Logs            = 项目程序日志目录<br>
<br>
实现功能：<br>
基于fast-route实现了路由<br>
基于Swoole实现了 Http Server<br>
基于Swoole协程Mysql库，实现了协程Mysql模型<br>
实现类：Input = 获取参数类， Message = 信息提示类<br>
<br>
进程出现异常导致退出，也会捕捉到错误，并且返回给客户端,<br>
程序逻辑错误异常，也可以捕捉到，并且返回给客户端,<br>
让客户端永远能正常收到服务端的返回信息。
<br>
另外实现了，基于Swoole Process，读取差大日志文件功能<br>
使用方式：php fileread.php
