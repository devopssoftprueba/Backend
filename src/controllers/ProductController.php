<?php

declare(strict_types=1);

namespace Controllers;

use Models\Product;
use PDO;
use PDOException;

/**
 * Clase ProductController.
 *
 * Esta clase representa el controlador encargado de gestionar productos incluyendo su obtencion desde la base de datos.
 *
 * @category Utilidades
 * @package  CustomModules
 * @author   Desconocido
 * @version  1.0.0
 * @since    2025-04-10
 */
class ProductController
{
    /**
     * Metodo getProducts.
     *
     * Obtiene todos los productos desde la base de datos utilizando una conexión PDO.
     *
     * @param PDO $pdo Instancia de la conexión PDO a la base de datos.
     *
     * @return array Arreglo de objetos Product obtenidos desde la base de datos.
     */
    public function getProducts(PDO $pdo): array
    {
        try {
            /**
             * Consulta SQL para obtener productos.
             *
             * @lang sql
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
