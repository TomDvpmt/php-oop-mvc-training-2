<?php

namespace PhpTraining2\core;

use PDO;
use Exception;
use PhpTraining2\core\Database;

trait Model {
    
    use Database;

    protected string $table = "users";
    protected string $columns = "*";
    protected string $where = "";
    protected int $limit = 20;
    protected int $offset = 0;
    protected string $orderColumn = "id";
    protected string $orderType = "desc";

    

    protected function setTable($newTable) {
        $this->table = $newTable;
    }

    protected function setWhere($where) {
        $this->where = "WHERE $where";
    }


    /**
     * Gets a list of rows from the database.
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param string $query The SQL query string
     * @param array $params The parameters of the query
     * @return mixed
     */

     protected function query($query, $params = []): mixed {
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

    protected function getLastInsertId(): int {
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
     * @param array $data
     * @return mixed
     */

    protected function find(array $data = []): mixed 
    {
        $query = "SELECT $this->columns FROM $this->table $this->where ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";
        $results = $this->query($query, $data);
        return $results;
    }


    /**
     * Add an entry in a table
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param array $data
     */

    protected function create(array $data): void 
    {
        $columns = implode(",", array_keys($data));
        $values = implode(",", array_map(fn($item) => ":" . $item, array_keys($data)));
        $query = "INSERT INTO $this->table ($columns) VALUES ($values);";
        
        $this->query($query, $data);
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

    protected function update(string $selectorKey, string $selectorValue, array $data): void 
    {
        $updates = implode(array_map(fn($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE $this->table SET $updates WHERE $selectorKey = :$selectorKey";
        $data = array_merge($data, [$selectorKey => $selectorValue]);

        $this->query($query, $data);
    }

    /**
     * Delete an item in a table
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param string $selectorKey The item selector's key (i.e. : "id")
     * @param string $selectorValue The item selector's value
     */

    protected function delete(string $selectorKey, string $selectorValue): void 
    {
        $query = "DELETE FROM $this->table WHERE $selectorKey = :$selectorKey";
        $this->query($query, [$selectorKey => $selectorValue]);
    }


    /**
     * Create a variable in $_SESSION
     * 
     * @access public
     * @package PhpTraining2\core
     * @param array $array
     */

    public function createInSession(array $array): void {
        foreach($array as $property => $value) {
            if(empty($_SESSION($property))) {
                $_SESSION[$property] = $value;
            }
        }
    }

    /**
     * Update a variable in $_SESSION
     * 
     * @access public
     * @package PhpTraining2\core
     * @param mixed $property
     * @param mixed $newValue
     */

    public function updateInSession(mixed $property, mixed $newValue) {
        $_SESSION[$property] = $newValue;
    }
}