<?php

/**
 * Clase de ejemplo para validación PHPDoc con PHP 8.2.
 *
 * @category Ejemplo
 * @package  BOEjemplo
 * @author   Ronald Pelaez
 * @version  1.0
 * @since    Archivo creado el 2025-04-04
 */
class BO
{
    /**
     * Nombre de la persona.
     *
     * @var string
     */
    private $nombre;

    /**
     * Constructor de la clase BO.
     *
     * @param string $nombre Nombre de la persona.
     */
    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Devuelve el nombre de la persona.
     *
     * @return string El nombre almacenado.
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}







