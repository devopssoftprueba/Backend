<?php

declare(strict_types=1);

namespace Models;

/**
 * Clase Product.
 *
 * Esta clase representa la entidad Product y contiene sus métodos y propiedades asociadas.
 *
 * @category Utilidades
 * @package  CustomModules
 * @author   Desconocido
 * @version  1.0.0
 * @since    2025-04-10
 */
class Product
{
    /**
     * ID del producto.
     *
     * @var integer Identificador único del producto.
     */
    private int $id;

    /**
     * Nombre del producto.
     *
     * @var string Nombre del producto.
     */
    private string $name;

    /**
     * Precio del producto.
     *
     * @var float Precio del producto.
     */
    private float $price;

    /**
     * Metodo __construct.
     *
     * Inicializa un nuevo producto con su ID, nombre y precio.
     *
     * @param integer $id    Identificador del producto.
     * @param string  $name  Nombre del producto.
     * @param float   $price Precio del producto.
     *
     * @return void
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
     * Convierte el objeto Product en un arreglo asociativo.
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
