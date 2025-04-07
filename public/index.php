<?php

/**
 * Punto de entrada principal para la aplicación.
 *
 * Este archivo enruta las peticiones al controlador correspondiente.
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/controllers/ProductController.php';

use Controllers\ProductController;

$controller = new ProductController();
$controller->index();
