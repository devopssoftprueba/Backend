<?php

declare(strict_types=1);

namespace Controllers;

use Models\Product;
use PDO;
use PDOException;

/**
 * Clase ProductController.
 *
 * Esta clase se encarga de gestionar la obtencion de productos desde la base de datos.
 *
 * @category Controllers
 * @package  Controllers
 * @author   Ronald
 * @version  1.0
 * @since    2025-04-09
 */
class ProductController
{
    /**
     * Metodo getProducts.
     *
     * Este metodo obtiene los productos almacenados en la base de datos
     * y los convierte en objetos Product.
     *
     * @param PDO $pdo Instancia de conexion a la base de datos.
     *
     * @return array Arreglo de objetos Product.
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
