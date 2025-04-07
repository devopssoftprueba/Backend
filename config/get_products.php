<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

try {
    /** @var PDO $pdo Conexión a la base de datos */
    $stmt = $pdo->query(/** @lang text */ 'SELECT id, name, price FROM products');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener productos.']);
}
