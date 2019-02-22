<?php

/**
 * default config file
 *
 *
 */
return [
    /**
     * all errors wouldn't display when set false
     *
     */
    'debug' => true,

    /**
     * default setting
     *
     */
    'default' => [
        'controller' => 'index',
        /**
         * default action getIndex() or postIndex()
         * which depends on request method
         *
         */
        'action' => 'index',
        /**
         * also can be set restful
         *
         */
        'route' => 'querystring',
    ],

    /**
     * view setting
     *
     */
    'view' => [
        'dir' => 'layout',
        'file' => 'base',
    ]
];
