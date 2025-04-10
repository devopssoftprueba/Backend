<?php

declare(strict_types=1);

use Controllers\ProductController;

require_once __DIR__ . '/../vendor/autoload.php'; // Si usas Composer
$pdo = require_once __DIR__ . '/database.php';     // Esto asigna el return del archivo a $pdo

$controller = new ProductController();
$products = $controller->getProducts($pdo);

echo json_encode($products);

