<?php

declare(strict_types=1);

namespace Controllers;

use Models\Product;
use PDO;
use PDOException;

/**
 * Controlador para gestión de productos.
 *
 * @category Controllers
 * @package  Controllers
 */
/**
 * Clase ProductController.
 *
 * Esta clase representa la entidad ProductController y contiene sus métodos y propiedades asociadas.
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
     * Obtiene los productos desde la base de datos.
     *
     * @param PDO $pdo Conexión PDO a la base de datos.
     *
     * @return array Arreglo de productos.
     */
    /**
 * Método getProducts.
 *
 * Descripción del método getProducts.
     *
 * @param  PDO $pdo Descripción del parámetro.
 * @return array Descripción del valor retornado.
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
