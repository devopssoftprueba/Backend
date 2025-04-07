<?php

/**
 * Obtiene los productos desde la base de datos.
 *
 * @category Endpoint
 * @package  Product
 * @author   Ronald Pelaez
 * @version  1.0.0
 * @since    1.0.0
 */

require_once 'database.php';

/**
 * obtiene la lista de productos desde la base de datos.
 * @var PDO $pdo Conexión PDO a la base de datos.
 */
global $pdo;

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($products);