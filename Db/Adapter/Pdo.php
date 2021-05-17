<?php 
/*
 * @author Joshua De Guzman
 * @licence MIT 
 */
namespace Db\Adapter;

use Db\Config;
use Db\Adapter\AdapterInterface;

/**
 * MySQLi Pdo
 */
class Pdo implements AdapterInterface
{
    private $_dbh;

    public function connect(Config $config)
    {
        
        $this->_dbh = new \PDO("mysql:host={$config->host};dbname={$config->dbname}", $config->user, $config->password);
    }
    public function fetchAll($sql, $parameters = [])
    {   
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth->fetchAll();
    }

    public function count($sql){
        $sth = $this->_dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchColumn();
    }

    public function insert($sql, $parameters = []){
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth;
    }

    public function find($sql, $parameters = []){
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth->fetch();
    }

    public function update($sql,$parameters = []){
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth;
    }
    
}


?>