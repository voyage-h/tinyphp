<?php

namespace Core;

use Dispatcher\Container;

class Router extends Container
{
    public $method;
    public $uri;
    public $path;
    public $controller;
    public $action;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->path = explode('?', $this->uri)[0];

        require APP_PATH. '/app/routes.php';
    }

    /**
     * 自定义路由
     *
     */
    public function __call($method,$args) 
    {
        if (empty($args[1])) {
            Error::fatal('Too few args in Router::method()');
        }
        $method = strtoupper($method);
        if ($this->method == $method && $this->path == $args[0]) {
            //执行闭包函数
            if (is_object($args[1])) {
                print_r(call_user_func($args[1]));
                exit;
            }
            
            //解析控制器
            list($this->controller, $this->action) = explode('@',$args[1]);
            if (empty($this->action)) {
                Error::fatal("Self defined routes must be controller@action");
            }

            //重定向控制器或路由
            $this->path = '/'.strtolower(str_replace(['Controller','get','@'],['','','/'],$args[1]));
            $this->uri = str_replace($args[0],$this->path,$this->uri);
        }

    }

    /**
     * 执行解析
     *
     */
    protected function start()
    {
        $route = Config::get('default.route', 'querystring');

        $path = explode('/',trim($this->path,'/'));
        
        //controller
        $controller = $this->controller ?? $this->getController($path[0]);

        //action
        $action = $this->action ?? $this->getAction($path[1] ?? null);

        //args
        $args = call_user_func_array([$this,$route],[$this->uri]);
        
        return ['controller'=>$controller,'action'=>$action,'args'=>$args];
    }

    /**
     * 获取控制器
     *
     *
     */
    private function getController($controller = null)
    {
        if (empty($controller)) {
            $controller = Config::get('default.controller', 'index');
        }
        return ucfirst($controller).'Controller';
    }

    /**
     * 获取方法名
     *
     */
    private function getAction($action = null)
    {
        if (empty($action)) {
            $action = Config::get('default.action', 'index');
        }
        return strtolower($this->method).ucfirst($action);
    }

    /**
     * 查询字符串解析
     *
     */
    private function querystring($url)
    {
        $urls = explode('?', $url);
        
        if (empty($urls[1])) {
            return [];
        }
        $param_tmp = explode('&', $urls[1]);
        if (empty($param_tmp)) {
            return [];
        }
        $param_arr = [];
        foreach ($param_tmp as $param) {
            if (strpos($param, '=')) {
                list($key,$value) = explode('=', $param);
                //变量名是否复合规则
                if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key)) {
                    $param_arr[$key] = $value;
                }
            }
        }
        return $param_arr;
    }
    /**
     * 路径 url 解析
     *
     */
    private function restful($url)
    {
        $path = explode('/', trim(explode('?', $url)[0], '/'));
        $params = [];
        $i = 2;
        while (1) {
            if (!isset($path[$i])) {
                break;
            }
            $params[$path[$i]] = $path[$i+1] ?? '';
            $i = $i+2;
        }
        return $params;
    }
}
