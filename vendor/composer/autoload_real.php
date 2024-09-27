<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbfb799e388e0045544f9bea2bb3d3b59
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitbfb799e388e0045544f9bea2bb3d3b59', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbfb799e388e0045544f9bea2bb3d3b59', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbfb799e388e0045544f9bea2bb3d3b59::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
