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
    
    public function fetchAll($sql)
    {
        $result = $this->_mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function count($sql){
        $sth = $this->_mysqli->query($sql);
        $sth->execute();
        return $sth>fetch_row();
    }

    
    public function insert($sql, $parameters = []){
        $sth = $this->_dbh->query($sql);
        $sth->execute($parameters);
        return $sth;
    }
    
}