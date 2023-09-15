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

        $queries = [
            // tables
            "
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(200) NOT NULL,
                    password_hash VARCHAR(255) NOT NULL,
                    is_admin BOOL DEFAULT 0 NOT NULL
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS products (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    category VARCHAR(50) NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    description VARCHAR(5000) NOT NULL,
                    price INT DEFAULT 0 NOT NULL DEFAULT 0,
                    img_url VARCHAR(255) NOT NULL
                );
            ",
                "
                CREATE TABLE IF NOT EXISTS shoes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL,
                    waterproof BOOL DEFAULT 1 NOT NULL,
                    level VARCHAR(50) DEFAULT 'regular' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS equipments (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL, 
                    activity VARCHAR(255) DEFAULT 'hiking' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            // triggers
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_shoe
                AFTER DELETE 
                ON shoes FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            ",
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_equipment
                AFTER DELETE 
                ON equipments FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            "
        ];

        try {
            foreach ($queries as $query) {
                $pdo->query($query);
            }
            $pdo = null;
        } catch(Exception $e) {
            die("Error : " . $e->getMessage());
        }
    }    
}