<?php

namespace Models;

/**
 * Class Product
 *
 * Representa un producto del catálogo.
 *
 * @category Models
 * @package  Models
 * @author   Ronald Pelaez
 * @version  1.0.0
 * @since    2025-04-06
 */
class Product
{
    /**
     * Identificador del producto.
     *
     * @var integer
     */
    private int $id;

    /**
     * Nombre del producto.
     *
     * @var string
     */
    private string $name;

    /**
     * Precio del producto.
     *
     * @var float
     */
    private float $price;

    /**
     * Establece los datos del producto.
     *
     * @param integer $id    ID del producto.
     * @param string  $name  Nombre del producto.
     * @param float   $price Precio del producto.
     *
     * @return void
     */
    public function setProductData(int $id, string $name, float $price): void
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * Obtiene los datos del producto.
     *
     * @return array Arreglo con ID, nombre y precio.
     */
    public function getProductData(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => $this->price,
        ];
    }
}
