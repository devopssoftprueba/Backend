<?php

declare(strict_types=1);

namespace Models;

/**
 * Clase que representa un producto.
 *
 * @category Models
 * @package  Models
 */
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
     * @param integer $name  Nombre del producto.
     * @param float   $price Precio del producto.
     */
    /**
 * Método __construct.
 *
 * Descripción del método __construct.
     *
 * @param  integer $id    Descripción del parámetro.
 * @param  string  $name  Descripción del parámetro.
 * @param  float   $price Descripción del parámetro.
 * @return void Descripción del valor retornado.
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
    /**
 * Método toArray.
 *
 * Descripción del método toArray.
     *
 * @return array Descripción del valor retornado.
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
