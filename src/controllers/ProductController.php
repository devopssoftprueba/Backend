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
            // Si no se encuentran productos, se devuelve un arreglo vacío
            return $products;
        } catch (PDOException $e) {
            return [];
        }
    }
}
