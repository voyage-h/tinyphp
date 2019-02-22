<?php

use Core\Router;

Router::get('/welcome', function(){
    return Config::get('db');
});
Router::get('/phpinfo', function(){
    return phpinfo();
});
