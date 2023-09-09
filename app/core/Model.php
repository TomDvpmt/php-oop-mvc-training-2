<?php

namespace PhpTraining2\core;

use PDO;
use Exception;
use PhpTraining2\core\Database;

trait Model {
    
    use Database;

    // default values
    protected string $table = "users";
    protected string $columns = "*";
    protected int $limit = 20;
    protected int $offset = 0;
    protected string $orderColumn = "id";
    protected string $orderType = "desc";


    /**
     * Gets a list of rows from the database.
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $query The SQL query string
     * @param array $params The optional parameters of the query
     * @return mixed
     */

     public function executeQuery($query, $params = []) {
        $pdo = $this->connect();

        try {
            $statement = $pdo->prepare($query);
            $check = $statement->execute($params);
            if($check) {
                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                if(is_array($result) && count($result)) {
                    return $result;
                }
            }
            $statement = null;
            $pdo = null;
            return false;

        } catch(Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }

    /**
     * Get id of last item added to table
     * 
     * @access public
     * @package PhpTraining/core
     * @return int
     */

    public function getLastInsertId() {
        $this->orderColumn = "id";
        $this->limit = 1;
        $result = $this->find();
        return $result[0]->id;
    }

    

    /**
     * Select entries in a table (or several joined tables)
     * 
     * @access public
     * @package PhpTraining2\core
     * @return array
     */

    public function find() 
    {
        $query = "SELECT $this->columns FROM $this->table ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";
        $results = $this->executeQuery($query);
        return $results;
    }


    /**
     * Add an entry in a table
     * 
     * @access public
     * @package PhpTraining2\core
     * @param array $data
     */

    public function create($data) 
    {
        $columns = array_keys($data);
        $values = array_map(fn($item) => "'" . $item . "'", array_values($data));
        $query = "INSERT INTO $this->table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ")";
        
        $this->executeQuery($query);
    }

    public function update($id, $data) 
    {

    }

    public function delete(string $key, string $value) 
    {
        $query = "DELETE FROM $this->table WHERE $key = $value";
        $this->executeQuery($query);
    }
    
}