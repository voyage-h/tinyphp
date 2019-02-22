<?php

namespace Plugin;

use Core\Plugin;
use Core\Config;
use Model\User;

class UserPlugin extends Plugin
{
    public function routerStartup()
    {
        echo "User : startup".PHP_EOL;
    }

    public function routerShutdown()
    {
        echo "User : shutdown".PHP_EOL;
    }
}
