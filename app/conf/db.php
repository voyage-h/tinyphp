<?php

/**
 * get this conf by Config::get('db')
 *
 */
return [
    /**
     * connect to mysql with pdo
     *
     *
     */
    'pdo' => [
        'ms' => 'mysql',
        'host' => 'mysql',
        'user' => 'root',
        'password' => 'mysql@zz1530',
        'database' => 'tinyphp',
    ],

    /**
     * redis db conf
     *
     *
     */
    'redis' => [
        'host' => 'localhost',
        'port' => 6379
    ]
];
