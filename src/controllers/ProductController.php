<?php

namespace Controllers;

use Models\Product;

/**
 * Controlador para manejar productos.
 *
 * @category Controller
 * @package  ProductController
 * @author   Ronald Pelaez
 * @version  1.0.0
 * @since    1.0.0
 */
class ProductController
{
    /**
     * Obtiene todos los productos.
     *
     * @return Product[] Lista de productos.
     */
    public function getAllProducts(): array
    {
        // Simulación de productos
        return [
            new Product(1, 'Producto A', 10.99),
            new Product(2, 'Producto B', 20.50),
        ];
    }
}
