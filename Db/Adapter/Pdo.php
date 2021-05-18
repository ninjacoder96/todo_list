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
    private $table_name = 'tasks';

    public function connect(Config $config)
    {
        
        $this->_dbh = new \PDO("mysql:host={$config->host};dbname={$config->dbname}", $config->user, $config->password);
    }
    /**
     * @param int $start
     * @param int $limit
     * @return array
     */
    public function fetchAll(int $start, int $limit) : array
    {      
        $sql = "SELECT * FROM  " . $this->table_name . " order BY id DESC limit :start,:limit";
        $sth = $this->_dbh->prepare($sql);
        $sth->bindValue("start", $start,\PDO::PARAM_INT);
        $sth->bindValue("limit", $limit,\PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }
    /**
     * @return string
     */
    public function count() : string
    {
        $sql = "SELECT count(*) from ".$this->table_name." ";
        $sth = $this->_dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchColumn();
    }

     /**
     * @param string $sql
     * @param array $parameters
     * @return object
     */
    public function insert(array $parameters = []) : object
    {
        $sql = "INSERT INTO ".$this->table_name."(title,description,created_at,updated_at)VALUES(:column1,:column2,:column3,:column4)";
        $sth = $this->_dbh->prepare($sql);
        $sth->execute($parameters);
        return $sth;
    }
    /**
     * @param string $sql
     * @param array $parameters
     * @return array
     */
    public function find(array $parameters = []): array
    {
        $id = $parameters["column1"];
        $sth = $this->_dbh->prepare("SELECT * FROM ".$this->table_name." where id = ?");
        $sth->execute([$id]);
        return $sth->fetch();
    }
     /**
     * @param string $sql
     * @param array $parameters
     * @return object
     */
    public function update(array $parameters = []) : object
    {
        $sth = $this->_dbh->prepare("UPDATE ".$this->table_name." set title=:column1,description=:column2,updated_at=:column3 where id = :column4");
        $sth->execute($parameters);
        return $sth;
    }
    /**
     * @param string $sql
     * @param array $parameters
     * @return object
     */
    public function delete(array $parameters = []): object
    {   
        $sth = $this->_dbh->prepare("DELETE FROM ".$this->table_name." where id = :column1");
        $sth->execute($parameters);
        return $sth;
    }

}


?>