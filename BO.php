<?php

/**
 * Clase de ejemplo para validar PHPDoc correctamente.
 *
 * @category Ejemplo
 * @package  DocumentacionValida
 * @author   Ronald Pelaez
 * @version  1.0
 * @since    Archivo disponible desde la versión 1.0
 */
class EjemploCorrecto
{
    /**
     * Nombre del usuario.
     *
     * @var string
     */
    private $nombre;

    /**
     * Constructor de la clase.
     *
     * @param string $nombre Nombre del usuario.
     */
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Obtiene el nombre del usuario.
     *
     * @return string Nombre del usuario.
     */
    public function obtenerNombre()
    {
        return $this->nombre;
    }
}


