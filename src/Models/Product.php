<?php

declare(strict_types=1);

namespace Models;

/**
 * Clase que representa un producto.
 *
 * @category Models
 * @package  Models
 */
class Product
{
    /**
     * ID del producto.
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
     * Constructor de la clase Product.
     *
     * @param integer $id    ID del producto.
     * @param string  $name  Nombre del producto.
     * @param float   $price Precio del producto.
     */
    public function __construct(
        int $id,
        string $name,
        float $price
    ) {
        $this->id    = $id;
        $this->name  = $name;
        $this->price = $price;
    }

    /**
     * Devuelve los datos del producto como arreglo.
     *
     * @return array Arreglo con los datos del producto.
     */
    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => $this->price,
        ];
    }
}