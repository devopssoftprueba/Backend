<?php

namespace Models;

/**
 * Clase Product que representa un producto del sistema.
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
     * @param integer    $id    Identificador del producto.
     * @param string $name  Nombre del producto.
     * @param float  $price Precio del producto.
     */
    public function __construct(int $id, string $name, float $price)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->price = $price;
    }

    /**
     * Obtiene el ID del producto.
     *
     * @return integer ID del producto.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre del producto.
     *
     * @return string Nombre del producto.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Obtiene el precio del producto.
     *
     * @return float Precio del producto.
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
