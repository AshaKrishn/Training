<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55ce244487521c391bf363660bd95f8e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'StoreApp\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'StoreApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55ce244487521c391bf363660bd95f8e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55ce244487521c391bf363660bd95f8e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit55ce244487521c391bf363660bd95f8e::$classMap;

        }, null, ClassLoader::class);
    }
}
