<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e10f0e4d355ac468afaf05fee6eb63c
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e10f0e4d355ac468afaf05fee6eb63c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e10f0e4d355ac468afaf05fee6eb63c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
