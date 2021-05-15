<?php 
namespace Db\Adapter;

use Db\Config;
/**
 * Abstract interface
 */
interface AdapterInterface
{
    public function connect(Config $config);
    public function fetchAll($sql, $parameters);
    public function count($sql);
    public function insert($sql,$parameters);
}

?>