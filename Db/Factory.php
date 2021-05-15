<?php 
namespace Db;
/**
 * Db Factory
 */
class Factory
{
    public static function connect(Config $config)
    {
        $className = sprintf("\\Db\\Adapter\\%s", $config->driver);
        if (class_exists($className)) {
            $adapter = new $className();
            $adapter->connect($config);
            return $adapter;
        }
    }
}






?>