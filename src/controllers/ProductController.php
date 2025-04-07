<?php

namespace Controllers;

use Models\Product;

/**
 * Controlador de productos.
 *
 * Maneja la lógica de negocio relacionada con los productos.
 *
 * @category Controllers
 * @package  Controllers
 */
class ProductController
{
    /**
     * Muestra una lista de productos.
     *
     * @return void
     */
    public function index(): void
    {
        $products = [
            new Product(1, 'Producto A', 10.5),
            new Product(2, 'Producto B', 20.0),
        ];

        header('Content-Type: application/json');
        echo json_encode(array_map(fn($p) => [
            'id'    => $p->getId(),
            'name'  => $p->getName(),
            'price' => $p->getPrice()
        ], $products));
    }
}
