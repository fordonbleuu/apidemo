<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'clifford_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `{$this->db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->conn->exec("USE `{$this->db_name}`");

            $this->conn->exec("CREATE TABLE IF NOT EXISTS items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                category VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");

            $check = $this->conn->query("SELECT COUNT(*) as cnt FROM items")->fetch();
            if ($check['cnt'] == 0) {
                $this->conn->exec("INSERT INTO items (name, description, price, category) VALUES
                    ('Sample Item 1', 'This is a sample item description', 19.99, 'General'),
                    ('Sample Item 2', 'Another sample item for testing', 29.99, 'General'),
                    ('Sample Item 3', 'A premium sample item', 49.99, 'Premium')
                ");
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Database connection failed: ' . $e->getMessage()]);
            exit;
        }

        return $this->conn;
    }
}
