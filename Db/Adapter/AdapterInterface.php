<?php 
/*
 * @author Joshua De Guzman
 * @licence MIT 
 */
namespace Db\Adapter;

use Db\Config;
/**
 * Abstract interface
 */
interface AdapterInterface
{
    public function connect(Config $config);
    public function fetchAll($start,$limit);
    public function count();
    public function insert($sql,$parameters);
    public function find($sql,$parameters);
    public function delete($sql,$parameters);
}

?>