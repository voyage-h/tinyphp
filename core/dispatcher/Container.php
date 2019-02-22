<?php 

namespace Dispatcher;

class Container extends Dispatcher
{

    public static $container = [];

    protected function getInstance($class = null)
    {
        //获取实例
        $class ?? $class = get_called_class();
        
        if (!isset(self::$container[$class]) || 
                !self::$container[$class] instanceof $class) {
            self::$container[$class] = self::newObject();
        }
        return self::$container[$class];
    }
}
