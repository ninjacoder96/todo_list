<?php
/*
 * @author Joshua De Guzman
 * @licence MIT 
 */
namespace Db\Adapter;

use Db\Config;


class Mysqli implements AdapterInterface
{
    private $_mysqli;

    public function connect(Config $config)
    {
        $this->_mysqli = new \mysqli($config->host, $config->user, $config->password
            , $config->dbname);
    }
    
    public function fetchAll($start,$limit) : array
    {
        $sql = "SELECT * FROM tasks order BY ID DESC limit $start,$limit";
        $result = $this->_mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function count(){
        $sql = $this->_mysqli->query("SELECT count(*) from tasks");
        $res = $sql->fetch_row();
        return $res[0];
    }

    
    public function insert($sql, $parameters = []) : object
    {
        $sth = $this->_mysqli->query($sql);
        $sth->bind_param($parameters);
        $sth->execute();
        return $sth;
    }

    public function find($sql, $parameters = []): array
    {
        $sth = $this->_mysqli->prepare($sql);
        $sth->bind_param($parameters);
        $sth->execute();
        return $sth;
    }

    public function update($sql,$parameters = []) : object
    {
        $sth = $this->_mysqli->prepare($sql);
        $sth->bind_param($parameters);
        $sth->execute();
        return $sth;
    }

    public function delete($sql,$parameters = []): object
    {   
        $sth = $this->_mysqli->prepare($sql);
        $sth->bind_param($parameters);
        $sth->execute();
        return $sth;
    }

    
}