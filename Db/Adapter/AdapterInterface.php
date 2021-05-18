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
    public function fetchAll(int $start,int $limit);
    public function count();
    public function insert(array $parameters);
    public function find(array $parameters);
    public function update(array $parameters);
    public function delete(array $parameters);
}

?>