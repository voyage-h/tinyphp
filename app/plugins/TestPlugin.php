<?php

namespace Plugin;

use Core\Plugin;

class TestPlugin extends Plugin
{
    public function routerStartup()
    {
        //action before router start up
    }

    public function routerShutdown()
    {
        //action after router shut down
    }
}