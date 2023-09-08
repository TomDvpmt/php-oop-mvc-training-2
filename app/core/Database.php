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
     * Initialize database
     * 
     * @access public
     * @package PhpTraining2\core
     */

    public function initializeDB() {
        $pdo = $this->connect();

        $productsQuery = "
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255),
                description VARCHAR(5000),
                price INT DEFAULT 0,
                img_url VARCHAR(255)
            );
        ";
        $shoesQuery = "
            CREATE TABLE IF NOT EXISTS shoes (
                shoe_id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT,
                waterproof BOOL DEFAULT 1,
                level VARCHAR(50) DEFAULT 'regular',
                FOREIGN KEY (product_id) REFERENCES products(id)
            );
        ";
        $equipmentsQuery = "
            CREATE TABLE IF NOT EXISTS equipments (
                equipment_id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT, 
                activity VARCHAR(255),
                FOREIGN KEY (product_id) REFERENCES products(id)
            );
        ";

        try {
            $statement = $pdo->query($productsQuery);
            $statement = $pdo->query($shoesQuery);
            $statement = $pdo->query($equipmentsQuery);
            $statement = null;
            $pdo = null;
        } catch(Exception $e) {
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
            $statement = null;
            $pdo = null;
            return false;

        } catch(Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }
    
}