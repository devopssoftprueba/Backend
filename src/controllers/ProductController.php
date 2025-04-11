<?php

declare(strict_types=1);

namespace Controllers;

use Models\Product;
use PDO;
use PDOException;


class ProductController
{
    /**
     * Obtiene los productos desde la base de datos.
     *
     * @param PDO $pdo Conexión PDO a la base de datos.
     *
     * @return array Arreglo de productos.
     */
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
