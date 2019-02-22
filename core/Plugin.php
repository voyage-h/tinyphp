<?php

namespace Core;

use Dispatcher\Container;

abstract class Plugin extends Container
{
    public abstract function routerStartup();
    public abstract function routerShutdown();
}
