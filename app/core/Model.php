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
     * @access protected
     * @package PhpTraining2\core
     * @param string $query The SQL query string
     * @param array $params The parameters of the query
     * @return mixed
     */

     protected function executeQuery($query, $params = []) {
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
     * @access protected
     * @package PhpTraining/core
     * @return int
     */

    protected function getLastInsertId() {
        $this->orderColumn = "id";
        $this->limit = 1;
        $result = $this->find();
        return $result[0]->id;
    }

    

    /**
     * Select entries in a table (or several joined tables)
     * 
     * @access protected
     * @package PhpTraining2\core
     * @return array
     */

    protected function find() 
    {
        $query = "SELECT $this->columns FROM $this->table ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";
        $results = $this->executeQuery($query);
        return $results;
    }


    /**
     * Add an entry in a table
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param array $data
     */

    protected function create($data) 
    {
        $columns = implode(",", array_keys($data));
        $values = implode(",", array_map(fn($item) => ":" . $item, array_keys($data)));
        $query = "INSERT INTO $this->table ($columns) VALUES ($values);";
        
        $this->executeQuery($query, $data);
    }

    /**
     * Update an item in a table
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param string $selectorKey The item selector's key (i.e. : "id")
     * @param string $selectorValue The item selector's value
     * @param array $data An associative array of columns (keys) and values to update
     */

    protected function update($selectorKey, $selectorValue, $data) 
    {
        $updates = implode(array_map(fn($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE $this->table SET $updates WHERE $selectorKey = :$selectorKey";
        $data = array_merge($data, [$selectorKey => $selectorValue]);

        $this->executeQuery($query, $data);
    }

    /**
     * Delete an item in a table
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param string $selectorKey The item selector's key (i.e. : "id")
     * @param string $selectorValue The item selector's value
     */

    protected function delete($selectorKey, $selectorValue) 
    {
        $query = "DELETE FROM $this->table WHERE $selectorKey = :$selectorKey";
        $this->executeQuery($query, [$selectorKey => $selectorValue]);
    }
    
}