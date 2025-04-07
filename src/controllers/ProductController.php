<?php
/**
 * Controlador de productos
 *
 * @package VirtualStore\Controllers
 * @author Ronald
 * @version 1.1
 */

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    /**
     * Muestra los productos disponibles
     */
    public function index()
    {
        $product = new Product();
        $products = $product->getAll();
        header('Content-Type: application/json');
        echo json_encode($products);
    }
}
