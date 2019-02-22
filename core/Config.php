<?php

namespace Core;

use Dispatcher\Container;

class Config extends Container
{
    private $conf;
    
    /**
     * 构造函数，获取配置文件，只加载一次
     * 
     */
    public function __construct()
    {
        $conf = [];
        $path = APP_PATH.'/app/conf/';
        foreach (scandir($path) as $file) {
            if (substr($file,-4) != '.php') {
                continue;
            }
            $filename = $path.$file;
            if ($file == 'config.php') {
                //1
                $conf += require $filename;
            } else {
                //2
                $k = explode('.', $file)[0];
                $conf[$k] = require $filename;
            }
        }
        $this->conf = $conf;
    }

    /**
     * 获取配置
     *
     */
    protected function get($key = null, $default=null)
    {
        //返回所有配置
        if (empty($key)) {
            return $this->conf;
        }
        //通过.获取层级关系
        if (strpos($key, '.')) {
            $conf = $this->conf;
            foreach (explode('.', $key) as $k) {
                $conf = $conf[$k] ?? $default;
            }
            return $conf;
        }
        return $this->conf[$key] ?? $default;
    }
}

