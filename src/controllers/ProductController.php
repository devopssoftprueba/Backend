<?php

namespace controllers;

use PDO;
use PDOException;

/**
 * Class ProductController
 *
 * Controlador para manejar las operaciones relacionadas con productos.
 *
 * @category Controller
 * @package  Controllers
 * @author   Ronald
 * @version  1.0
 * @since    2024-01-01
 */
class ProductController
{
    /**
     * Get products from the database using PDO.
     *
     * @return array Arreglo asociativo con los datos de los productos.
     */
    public function getProductsPDO(): array
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=test_db', 'root', '');
            $stmt = $db->query('SELECT * FROM products');

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
