<?php
/**
 * Modelo de Producto
 *
 * @package VirtualStore\Models
 * @author Ronald
 * @version 1.1
 */

require_once __DIR__ . '/../../config/database.php';

class Product
{
    /**
     * Devuelve todos los productos desde la base de datos
     *
     * @return array
     */
    public function getAll(): array
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
