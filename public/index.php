<?php
declare(strict_types=1);

/**
 * Punto de entrada del backend
 *
 * @package VirtualStore\Public
 * @author Ronald
 * @version 1.0
 */

require_once __DIR__ . '/../src/controllers/ProductController.php';

$controller = new ProductController();
$controller->index();
