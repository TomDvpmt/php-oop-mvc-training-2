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
     * @return PDO
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
                    password VARCHAR(255) NOT NULL,
                    first_name VARCHAR(200),
                    last_name VARCHAR(200),
                    is_admin BOOL DEFAULT 0 NOT NULL
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS products (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    category VARCHAR(50) NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    description VARCHAR(5000) NOT NULL,
                    special_features VARCHAR(5000) NOT NULL,
                    limitations VARCHAR(5000) NOT NULL,
                    price INT DEFAULT 0 NOT NULL DEFAULT 0,
                    thumbnail VARCHAR(255) DEFAULT 'default_product_thumbnail.webp' NOT NULL
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS books (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL, 
                    genre VARCHAR(255) DEFAULT 'fantasy' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS protection (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL,
                    type VARCHAR(255) DEFAULT 'hard to say' NOT NULL,
                    resistance VARCHAR(255) DEFAULT 'medium' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS shoes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL,
                    waterproof VARCHAR(50) DEFAULT 'unsure' NOT NULL,
                    usage_intensity VARCHAR(50) DEFAULT 'on sundays only' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS vehicles (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL,
                    airborne VARCHAR(50) DEFAULT 'occasionally' NOT NULL,
                    aquatic VARCHAR(50) DEFAULT 'reasonnably' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            "
                CREATE TABLE IF NOT EXISTS weapons (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT NOT NULL,
                    ideal_range VARCHAR(255) DEFAULT 'medium' NOT NULL,
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ",
            
            // triggers
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_book
                AFTER DELETE 
                ON books FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            ",
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_protection
                AFTER DELETE 
                ON protection FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            ",
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_shoe
                AFTER DELETE 
                ON shoes FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            ",
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_vehicle
                AFTER DELETE 
                ON vehicles FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            ",
            "
                CREATE TRIGGER IF NOT EXISTS delete_product_after_delete_weapon
                AFTER DELETE 
                ON weapons FOR EACH ROW
                DELETE FROM products
                WHERE id = old.product_id;
            ",     
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