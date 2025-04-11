<?php

declare(strict_types=1);

namespace VSBackend\src\controllers;

use Models\Product;
use PDO;
use PDOException;

/**
 * Controlador para gestión de productos.
 *
 * @category Controllers
 * @package  Controllers
 */
class ProductController
{

    public function getProducts(PDO $pdo): array
    {
        try {
            /**
             * Consulta SQL para obtener productos.
             *
             * @lang text
             */
            $stmt = $pdo->query('SELECT id, name, price FROM products');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];

            foreach ($result as $row) {
                $products[] = new Product(
                    (int) $row['id'],
                    $row['name'],
                    (float) $row['price']
                );
            }

            return $products;
        } catch (PDOException $e) {
            return [];
        }
    }
}
