<?php

namespace App;

use Core\Application;
use Plugin\UserPlugin;
use Plugin\AdminPlugin;
use Dispatcher\Container;

class Bootstrap extends Container
{
    public function initRegisterPlugin(Application $app, UserPlugin $user, AdminPlugin $admin)
    {
        //$app->plugin($user);
        //$app->plugin($admin);
    }
}
