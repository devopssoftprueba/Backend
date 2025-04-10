<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Carga automática de clases PSR-4

use Controllers\ProductController; // Usamos el namespace correcto mapeado en composer.json

$controller = new ProductController();
$products   = $controller->getProductsPDO();

header('Content-Type: application/json');
echo json_encode($products);
