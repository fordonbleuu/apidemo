CREATE DATABASE IF NOT EXISTS clifford_db;
USE clifford_db;

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO items (name, description, price, category) VALUES
('Sample Item 1', 'This is a sample item description', 19.99, 'General'),
('Sample Item 2', 'Another sample item for testing', 29.99, 'General'),
('Sample Item 3', 'A premium sample item', 49.99, 'Premium');
