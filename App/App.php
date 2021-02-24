<?php


class App
{
    public static $router;
    public static $db;
    public static $kernel;
    public static $model;

    public static function init()
    {
        spl_autoload_register(['static','loadClass']);
        static::bootstrap();
    }

    public static function bootstrap()
    {
        static::$router = new App\Router();
        static::$kernel = new App\Kernel();
        static::$db = new App\Db();
        static::$model = new App\Model();
    }

    public static function loadClass ($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        require_once ROOTPATH.DIRECTORY_SEPARATOR.$className.'.php';
    }


}