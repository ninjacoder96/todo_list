<?php 
/*
 * @author Joshua De Guzman
 * @licence MIT 
 */
namespace Db\Adapter;

use Db\Config;
use Db\Adapter\AdapterInterface;


class Pdo implements AdapterInterface
{
    private $_dbh;

    public function connect(Config $config)
    {
        
        $this->_dbh = new \PDO("mysql:host={$config->host};dbname={$config->dbname}", $config->user, $config->password);
    }
    public function fetchAll($start,$limit) : array
    {      
        $query = "SELECT * FROM tasks order BY ID DESC limit $start,$limit";
        $sth = $this->_dbh->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function count() : string
    {
        $sth = $this->_dbh->prepare("SELECT count(*) from tasks");
        $sth->execute();
        return $sth->fetchColumn();
    }

    public function insert($sql, $parameters = []) : object
    {
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth;
    }

    public function find($sql, $parameters = []): array
    {
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth->fetch();
    }

    public function update($sql,$parameters = []) : object
    {
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth;
    }

    public function delete($sql,$parameters = []): object
    {   
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth;
    }
    
}


?>