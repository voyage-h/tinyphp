<?php

namespace plugin;

use core\Plugin;

class AdminPlugin extends Plugin
{
    public function routerStartup()
    {
        echo "Admin : startup".PHP_EOL;
    }
    public function routerShutdown()
    {
        echo "Admin : shutdown".PHP_EOL;
    }
}
