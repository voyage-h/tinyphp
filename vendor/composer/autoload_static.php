<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit991b87664b54cfabc54263ae13cdf88a
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'View\\' => 5,
        ),
        'T' => 
        array (
            'Test\\' => 5,
        ),
        'P' => 
        array (
            'Plugin\\' => 7,
        ),
        'M' => 
        array (
            'Model\\' => 6,
            'Migration\\' => 10,
        ),
        'L' => 
        array (
            'Library\\' => 8,
        ),
        'H' => 
        array (
            'Helper\\' => 7,
        ),
        'E' => 
        array (
            'Error\\' => 6,
        ),
        'D' => 
        array (
            'Dispatcher\\' => 11,
        ),
        'C' => 
        array (
            'Core\\' => 5,
            'Controller\\' => 11,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'View\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/views',
        ),
        'Test\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Plugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/plugins',
        ),
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'Migration\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/migrations',
        ),
        'Library\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/library',
        ),
        'Helper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core/helper',
        ),
        'Error\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core/error',
        ),
        'Dispatcher\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core/dispatcher',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit991b87664b54cfabc54263ae13cdf88a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit991b87664b54cfabc54263ae13cdf88a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}