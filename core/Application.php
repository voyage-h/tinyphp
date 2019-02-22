<?php

namespace Core;

use Dispatcher\Container;
use App\Bootstrap;

class Application extends Container
{
    public $plugins;
    public $boot;

    /**
     * 设置错误处理
     * 加载辅助函数
     * 初始化Bootstrapp
     *
     */
    public function __construct()
    {
        ob_start();
        register_shutdown_function([$this, 'error']);
        require APP_PATH.'/core/helper/funcs.php';
        $this->boot = Bootstrap::register();
    }

    public function error()
    {
        $data = ob_get_clean();
        $res = error_get_last();
        if (in_array($res['type'], [1, 4,16, 64, 256, 4096])) {
            $tmp = explode('Stack trace:', $res['message']);
            $msg = $tmp[0];
            if (!isset($tmp[1])) {
                $msg .= " in ".$res['file']. ':'.$res['line'];
            }
            $msg = substr($msg, strpos($msg, ':') + 1);

            Error::fatal(trim($msg), $tmp[1] ?? '');
        }
        echo $data;
    }

    /**
     * 加载启动项
     * 执行插件
     * 路由解析
     * 调用控制器方法
     * 输出内容
     */
    public function run()
    {
        //该类中所有以init开头的方法都会被调用
        $funcs = array_filter(get_class_methods($this->boot),[$this,'getBootFuncs']);
        foreach($funcs as $func) {
            Bootstrap::call($func);
        }

        //路由前插件执行
        if (!empty($this->plugins)) {
            foreach($this->plugins as $plugin) {
                //$plugin::call('routerStartup');
                $plugin->routerStartup();
            }
        }

        if (($controller = $this->request->controller)) {
            $action = $this->request->action;
            $args = $this->request->args ?? [];
        } else {

            //路由解析
            $router = Router::start();
            $controller = "Controller\\".$router['controller'];
            $action = $router['action'];
            $args = $router['args'];
            $this->controller = $router['controller'];
            $this->action = $router['action'];
            $this->args = $router['args'];
        }

        //路由解析后插件执行
        if (!empty($this->plugins)) {
            foreach($this->plugins as $plugin) {
                $plugin->routerShutdown();
            }
        }
        print_r($controller::call($action,$args));
    }

    private function getBootFuncs($func)
    {
        return 0 === strpos($func, 'init') ? 1 : 0;
    }
    public function __set($key, $value)
    {
        $this->request->$key = $value;
    }

    public function plugin($plugin)
    {
        $this->plugins[] = $plugin;
    }

}
