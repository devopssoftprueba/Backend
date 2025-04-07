<?php

require_once 'database.php';

/**
 * Get products from the database.
 *
 * Retrieves a list of products including ID, name, and price.
 *
 * @param PDO $pdo The PDO connection to the database.
 * @return array The list of products retrieved from the database.
 */
function getProducts(PDO $pdo): array
{
    $stmt = $pdo->prepare('SELECT id, name, price FROM products');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
