<?php

namespace Models;

/**
 * Class Product
 *
 * Modelo que representa un producto del sistema (el comentario de este archivo lo hice el local, lo debe validar).
 *
 * @category Model
 * @package  models
 * @author   Ronald
 * @version  1.0
 * @since    2024-01-01
 */
class Product
{
    /**
     * Descripcion de la documentacion
     *
     * @var integer $id Identificador único del producto.
     */
    private int $id;

    /**
     * Descripcion de la documentacion
     *
     * @var string $name Nombre del producto.
     */
    private string $name;

    /**
     * Descripcion de la documentacion
     *
     * @var float $price Precio del producto.
     */
    private float $price;

    /**
     * Constructor del modelo Product.
     *
     * @param integer $id    Identificador único del producto (comentario cambiado).
     * @param string  $name  Nombre del producto.
     * @param float   $price Precio del producto.
     */
    public function __construct(int $id, string $name, float $price)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->price = $price;
    }

    /**
     * Devuelve los datos del producto en forma de arreglo.
     *
     * @return array Datos del producto
     */
    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => $this->price,
        ];
    }

    /**
     * Calcula el precio con descuento aplicad.
     *
     * @param float $percentage Porcentaje de descuento a aplicar (ej. 10 para 10%).
     *
     * @return float Precio con descuento aplicado.
     */
    public function getDiscountedPrice(float $percentage): float
    {
        $discount = ($this->price * $percentage) / 100;
        return $this->price - $discount;
    }
}

