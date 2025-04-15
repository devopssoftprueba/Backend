<?php

declare(strict_types=1);

namespace VSBackend\src\controllers;

use Models\Product;
use PDO;
use PDOException;


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
            // Si no se encuentran productos, se devuelve un arreglo vacío
            return $products;
        } catch (PDOException $e) {
            return [];
        }
    }
}
