<?php

declare(strict_types=1);

require_once 'database.php';

/**
 * Retrieves a list of products including ID, name, and price.
 *
 * This function executes a query on the "products" table and fetches all rows
 * using associative array format.
 *
 * @param  PDO   $pdo  The PDO connection to the database.
 *
 * @return array       The list of products retrieved from the database.
 */
function getProducts(PDO $pdo): array
{
    $stmt = $pdo->prepare('SELECT id, name, price FROM products');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
