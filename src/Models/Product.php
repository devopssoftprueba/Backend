<?php

declare(strict_types=1);

namespace Models;

/**
 * Clase que representa un producto con convención de nombres incorrecta y línea larga para pruebas.
 *
 * @category Models
 * @package  Models
 */
class Producto_invalido
{
    /**
     * ID del producto.
     *
     * @var integer
     */
    private int $producto_id;

    /**
     * Nombre del producto.
     *
     * @var string
     */
    private string $nombre_producto;

    /**
     * Precio del producto.
     *
     * @var float
     */
    private float $precio_producto;

    /**
     * Constructor de la clase Producto_invalido.
     *
     * @param integer $producto_id     ID del producto.
     * @param string  $nombre_producto Nombre del producto.
     * @param float   $precio_producto Precio del producto.
     */
    public function __construct(
        int $producto_id,
        string $nombre_producto,
        float $precio_producto
    ) {
        $this->producto_id     = $producto_id;
        $this->nombre_producto = $nombre_producto;
        $this->precio_producto = $precio_producto;
    }

    /**
     * Devuelve los datos del producto como arreglo.
     *
     * @return array Arreglo con los datos del producto.
     */
    public function obtener_datos_del_producto()
    {
        return [ 'producto_id' => $this->producto_id, 'name_product' => $this->nombre_producto, 'precio_producto' => $this->precio_producto, 'descripcion_extensa_con_mucho_texto_para_validar_que_no_explota_con_lineas_largas_1234567890_ABCDEFGHIJKLMN_opqrstuvwxyz' => 'Ejemplo de descripción muy extensa que excede cualquier límite razonable de longitud para una línea, ideal para prueba de reglas de longitud' ];
    }
}
