<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita24b762d1357edf7fdd4e0d135d86a89
{
    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInita24b762d1357edf7fdd4e0d135d86a89::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}