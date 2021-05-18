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
    private $table_name = 'tasks';
     /**
     * @param Class Config
     */
    public function connect(Config $config)
    {
        $this->_mysqli = new \mysqli($config->host, $config->user, $config->password
            , $config->dbname);
    }
    
    /**
     * @param int $start
     * @param int $limit
     * @return array
     */
    public function fetchAll(int $start,int $limit) : array
    {
        $sql = "SELECT * FROM tasks order BY ID DESC limit ?,?";
        $sth = $this->_mysqli->prepare($sql);
        $sth->bind_param('ii',$start,$limit);
        $sth->execute();
        $res = $sth->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
      /**
     * @return string
     */
    public function count(){
        $sql = $this->_mysqli->query("SELECT count(*) from tasks");
        $res = $sql->fetch_row();
        return $res[0];
    }
    /**
     * @param string $sql
     * @param array $parameters
     * @return object
     */
    public function insert(array $parameters = []) : object
    {
        $title = $parameters["column1"];
        $desc = $parameters["column2"];
        $created_at = $parameters["column3"];
        $updated_at = $parameters["column4"];
        $sth = $this->_mysqli->prepare('INSERT INTO tasks (title, description,created_at,updated_at) VALUES (?,?,?,?)');
        $sth->bind_param('ssss', $title,$desc,$created_at,$updated_at);
        $sth->execute();
        return $sth;
    }
     /**
     * @param string $sql
     * @param array $parameters
     * @return object
     */
    public function find(array $parameters = []) : object
    {
        $id = $parameters["column1"];
        $sth = $this->_mysqli->prepare("SELECT * FROM ".$this->table_name." where id = ?");
        $sth->bind_param('i',$id);
        $sth->execute();
        $res = $sth->get_result();
        return $res->fetch_object();
    }
    /**
     * @param string $sql
     * @param array $parameters
     * @return object
     */
    public function update(array $parameters = []) : object
    {
        $sql = "UPDATE tasks set title=?,description=?,updated_at=? where id = ?";
        $sth = $this->_mysqli->prepare($sql);
        $sth->bind_param('sssi',$parameters["column1"],$parameters["column2"],$parameters["column3"],$parameters["column4"]);
        $sth->execute();
        return $sth;
    }

    public function delete(array $parameters = []): object
    {   
        $sql = "DELETE FROM ".$this->table_name." where id = ?";
        $sth = $this->_mysqli->prepare($sql);
        $sth->bind_param('i',$parameters["column1"]);
        $sth->execute();
        return $sth;
    }

    
}