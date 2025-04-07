CREATE DATABASE IF NOT EXISTS virtualstore;
USE virtualstore;

CREATE TABLE products (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(100) NOT NULL,
                          description TEXT,
                          price DECIMAL(10, 2) NOT NULL,
                          stock INT NOT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, stock) VALUES
                                                           ('Camisa básica', 'Camisa 100% algodón', 29.99, 100),
                                                           ('Zapatos deportivos', 'Zapatos cómodos para correr', 49.99, 50),
                                                           ('Pantalón jean', 'Pantalón azul clásico', 39.99, 80);
