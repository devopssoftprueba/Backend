<?php

/**
 * Endpoint para obtener la lista de productos de la tienda.
 *
 * @package Backend
 * @author Ronald
 * @version 1.0
 * @since 2025-04-06
 */

require_once 'database.php';

header('Content-Type: application/json');

$pdo = getPDO();

try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
