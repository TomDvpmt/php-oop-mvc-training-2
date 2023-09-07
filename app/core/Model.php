<?php

namespace PhpTraining2\core;

use PhpTraining2\core\Database;

trait Model {
    
    use Database;

    // default values
    protected string $table = "users";
    protected int $limit = 10;
    protected int $offset = 0;
    protected string $orderColumn = "id";
    protected string $orderType = "desc";
    

    /**
     * Gets all the result rows from a query.
     * 
     * @access public
     * @package PhpTraining2\core
     * @return array
     */

    public function findAll() 
    {
        $query = "SELECT * FROM $this->table ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";

        $results = $this->getRows($query);
        return $results;
    }

    /**
     * Gets a limited number of result rows from a query. 
     * 
     * @access public
     * @package PhpTraining2\core
     * @param array $data
     * @param array $dataNot
     * @return array
     */


    public function findSome(array $data, array $dataNot = []) 
    {
        $keys = array_keys($data);
        $keysNot = array_keys($dataNot);
        $query = "SELECT * FROM $this->table WHERE ";
        
        foreach($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }
        foreach($keysNot as $key) {
            $query .= $key . " = :" . $key . " && ";
        }
        $query = trim($query, " && ");

        $query .= " ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";
        $data = array_merge($data, $dataNot);

        $results = $this->getRows($query, $data);


        return $results ? $results : false;
    }

    /**
     * Gets first result row from a query. 
     * 
     * @access public
     * @package PhpTraining2\core
     * @param array $data
     * @return array
     */

    public function findOne(array $data) 
    {
        $results = $this->findSome($data);

        return $results ? $results[0] : false;
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
        
        $this->getRows($query);
    }

    public function update($id, $data) 
    {

    }

    public function delete($id) 
    {

    }
    
}