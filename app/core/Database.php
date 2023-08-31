<?php

namespace PhpTraining2\core;

use PDO;
use Exception;

trait Database {
    
    /**
     * Connects to the database with PDO
     * 
     * @access private
     * @package PhpTraining2\core
     * @return object
     */
    
    private function connect() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            return $pdo;
        } catch (Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }

    /**
     * Gets a list of rows from the database.
     * 
     * @access public
     * @package PhpTraining2\core
     * @param string $query The SQL query string
     * @param array $params The optional parameters to the query
     * @return mixed
     */

     public function getRows($query, $params = []) {
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
            return false;

        } catch(Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }
    
}