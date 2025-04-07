<?php

/**
 * Recupera todos los productos desde la base de datos.
 *
 * Este archivo realiza una consulta a la tabla `products` y retorna un JSON con los resultados.
 */

declare(strict_types=1);

$pdo = require __DIR__ . '/database.php';

$stmt = $pdo->query(/** @lang SQL */ 'SELECT id, name, price FROM products');
$products = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($products);
