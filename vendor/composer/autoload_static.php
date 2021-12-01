<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit814193b1f998f36e9a0fa2f8a9b6e32e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit814193b1f998f36e9a0fa2f8a9b6e32e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit814193b1f998f36e9a0fa2f8a9b6e32e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit814193b1f998f36e9a0fa2f8a9b6e32e::$classMap;

        }, null, ClassLoader::class);
    }
}
