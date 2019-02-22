<?php 

namespace Dispatcher;

class Box extends Dispatcher
{
    protected function getInstance()
    {
        return self::newObject();
    }
}
