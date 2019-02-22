<?php

namespace Library;

use Predis;
use Dispatcher\Container;

class Redis extends Container
{
    protected $redis;

    public function __construct()
    {
        Predis\Autoloader::register();
        $this->redis = new Predis\Client(Config::get('db.redis'));
    }

    public function __call($method,$args)
    {
        return call_user_func_array([$this->redis,$method], $args);
    }

    protected function set($key,$value,$expireTTL = null)
    {
        if (empty($expireTTL)) {
            return $this->redis->set($key, $value);
        }
        return $this->redis->setex($key,$expireTTL,$value);
    }
    protected function hasKey($key)
    {
        return $this->redis->exists($key);
    }
}
