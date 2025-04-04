<?php

/**
 * Clase de ejemplo para prueba de validación PHPDoc.
 *
 * @category Demo
 * @package  BOExample
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
    private string $nombre;

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
     * Obtiene el nombre de la persona.
     *
     * @return string Retorna el nombre.
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }
}
