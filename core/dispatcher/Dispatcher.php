<?php 

namespace Dispatcher;

use Core\Application;
use Core\Error;
use Helper\Post;

abstract class Dispatcher
{
    //实例化操作
    abstract protected function getInstance();

    /**
     * 调用不存在的静态方法时执行
     *
     */
    public static function __callstatic($method, $args)
    {
        $instance = static::getInstance();

        if (method_exists($instance, 'init')) {
            call_user_func_array([$instance, 'init'], $args);
        }

        return call_user_func_array(array($instance, $method), $args);
    }

    /**
     * 使用Static延迟静态绑定
     *
     */
    public static function newObject()
    {
        return new Static;
    }

    /**
     * 获取子类实例
     *
     */
    public static function register() 
    {
        return static::getInstance();
    }

    /**
     * 依赖注入，默认参数绑定
     * @param string $method
     * @param array $args
     *
     */
    protected function call(string $method, $args = null)
    {
        $object = get_called_class();//Bootstrap
        $reflect = new \ReflectionMethod($object, $method);//initRegisterPlugin
        
        $params = [];
        foreach ($reflect->getParameters() as $need) {
            //依赖注入
            if (isset($need->getClass()->name)) {
                $obj = $need->getClass()->name;
                $params[$need->name] = $obj::register();
            //默认参数
            } else {
                if (!$need->isDefaultValueAvailable()
                && !isset($args[$need->name])) {
                    Error::fatal('action [ '.$method.' ] needs params [ $'.$need->name.' ]');
                }
                $params[$need->name] = $args[$need->name] ?? $need->getDefaultValue();
            }
        }
        $instance = $object::register();
        if (method_exists($instance, 'init')) {
            call_user_func_array([$instance, 'init'], $args);
        }
        return $reflect->invokeArgs($instance, $params);
    }

    public function __call($method, $args)
    {
        $object = static::getInstance();

        return call_user_func_array([$object, $method], $args);
    }
    /**
     *
     * @param string $key
     * @return string
     */
    public function __get(string $key) 
    {
        switch ($key) {
            case 'request':
                $res = Application::register();
                break;
            case 'response':
                $res = \Core\Response::register();
                break;
            case 'isAjax':
                $hxrw = $_SERVER["HTTP_X_REQUESTED_WITH"] ?? '';
                $res = $hxrw == "xmlhttprequest" ? true : false;
                break;
            case 'post':
                $res = Post::filter();
                break;
            default :
                $res = null;

        }
        return $res;
    }

}
