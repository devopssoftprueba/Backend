<?php

namespace Controllers;

use PDO;
use PDOException;

/**
 * Class ProductController
 *
 * Controlado
 * (esto que es nuevo se agrega desde github y no se debe validar nada de este archivo en el local).
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
        /**
         * Descripción del metodo.
         *
         * @return void
         */

        try {
            $db = new PDO('mysql:host=localhost;dbname=test_db', 'root', '');
            $stmt = $db->query('SELECT * FROM products');

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
