<?php

declare(strict_types=1);

namespace Models;

/**
 * Clase Product.
 *
 * Esta clase representa un producto con identificador, nombre y precio.
 *
 * @category Models
 * @package  Models
 * @author   Ronald
 * @version  1.0
 * @since    2025-04-09
 */
class Product
{
    /**
     * Identificador unico del producto.
     *
     * @var integer $id Identificador del producto.
     */
    private int $id;

    /**
     * Nombre del producto.
     *
     * @var string $name Nombre del producto.
     */
    private string $name;

    /**
     * Precio del producto.
     *
     * @var float $price Precio del producto.
     */
    private float $price;

    /**
     * Metodo constructor.
     *
     * Este metodo inicializa un producto con sus atributos basicos.
     *
     * @param integer $id    Identificador unico del producto.
     * @param string  $name  Nombre del producto.
     * @param float   $price Precio del producto.
     *
     * @return void Este metodo no retorna ningun valor.
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
     * Metodo toArray.
     *
     * Este metodo convierte el producto a un arreglo asociativo.
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
