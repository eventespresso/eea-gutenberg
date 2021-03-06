<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7d91f0f1584b8949b47ebe233ec24deb
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'EE\\Gutenberg\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'EE\\Gutenberg\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'C' => 
        array (
            'Composer\\Installers\\' => 
            array (
                0 => __DIR__ . '/..' . '/composer/installers/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7d91f0f1584b8949b47ebe233ec24deb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7d91f0f1584b8949b47ebe233ec24deb::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7d91f0f1584b8949b47ebe233ec24deb::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
