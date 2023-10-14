<?php

namespace PhpTraining2\core;

use PDO;
use Exception;
use PDOException;
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

    /**
     * Set table
     * 
     * @access protected
     * @package PhpTraining2\core
     */

    protected function setTable(string $newTable) {
        $this->table = $newTable;
    }

    /**
     * Set columns
     * 
     * @access protected
     * @package PhpTraining2\core
     */

    protected function setColumns(string $columns) {
        $this->columns = $columns;
    }

    /**
     * Set where clause
     * 
     * @access protected
     * @package PhpTraining2\core
     */

    protected function setWhere(string $where) {
        $this->where = $where;
    }

    /**
     * Set the limit number of results
     * 
     * @access protected
     * @package PhpTraining2\core
     */

     protected function setLimit(int $limit) {
        $this->limit = $limit;
    }

    /**
     * Set the column used to order results
     * 
     * @access protected
     * @package PhpTraining2\core
     */

     protected function setOrderColumn(string $column) {
        $this->orderColumn = $column;
    }


    /**
     * Gets a list of rows from the database.
     * 
     * @access protected
     * @package PhpTraining2\core
     * @param string $query The SQL query string
     * @param array $params The parameters of the query
     * @return array|bool
     */

     protected function query($query, $params = []): array|bool {
        
        try {
            $pdo = $this->connect();
            $statement = $pdo->prepare($query);
            $check = $statement->execute($params);
            if(!$check) {
                throw new PDOException("PDO statement execution error.");
            }
            $results = $statement->fetchAll(PDO::FETCH_OBJ);
            if(!is_array($results)) {
                throw new PDOException("PDO statement fetching error.");
            }
            if(!count($results)) {
                return false;
            };

        } catch (Exception $e) {
            $statement = null;
            $pdo = null;
            return false;
        }

        return $results;
    }

    /**
     * Get id of last item added to table
     * 
     * @access protected
     * @package PhpTraining/core
     * @return int
     */

    protected function getLastInsertId(): int {
        $this->setOrderColumn("id");
        $this->setLimit(1);
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
        $whereClause = !empty($this->where) ? "WHERE $this->where" : "";
        $query = "SELECT $this->columns FROM $this->table $whereClause ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";
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