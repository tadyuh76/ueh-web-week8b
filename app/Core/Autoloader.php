<?php
namespace App\Core;

class Autoloader {
    private static $basePath;
    
    public static function register() {
        self::$basePath = dirname(dirname(__DIR__));
        spl_autoload_register([__CLASS__, 'load']);
    }
    
    private static function load($className) {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        
        $file = self::$basePath . DIRECTORY_SEPARATOR . $className . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        
        return false;
    }
}