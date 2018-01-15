<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita914701073564d656a94d618f511ec5e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slince\\ComposerAlias\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slince\\ComposerAlias\\' => 
        array (
            0 => __DIR__ . '/..' . '/slince/composer-alias/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita914701073564d656a94d618f511ec5e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita914701073564d656a94d618f511ec5e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}