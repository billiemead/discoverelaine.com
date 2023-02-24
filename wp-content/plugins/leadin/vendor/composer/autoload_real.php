<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita1516ef8fdbfabec4d96acdd967d144b
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInita1516ef8fdbfabec4d96acdd967d144b', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita1516ef8fdbfabec4d96acdd967d144b', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita1516ef8fdbfabec4d96acdd967d144b::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
