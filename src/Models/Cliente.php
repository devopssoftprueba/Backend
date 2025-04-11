<?php

namespace Models;

/**
 * Clase Cliente
 *
 * Representa a un cliente del sistema, incluyendo información de contacto y estado.
 *
 * @category Models
 * @package  Models
 * @author   Ronald
 * @version  1.0.0
 * @since    Archivo disponible desde la versión 1.0.0
 */
class Cliente
{
    /**
     * Identificador único del cliente
     *
     * @var integer
     */
    private $id;

    /**
     * Nombre del cliente
     *
     * @var string
     */
    private $nombre;

    /**
     * Correo electrónico del cliente
     *
     * @var string
     */
    private $email;

    /**
     * Estado del cliente (activo/inactivo)
     *
     * @var boolean
     */
    private $activo;

    /**
     * Constructor de la clase Cliente
     *
     * Inicializa un nuevo cliente con los datos básicos.
     *
     * @param integer $id ID del cliente
     * @param string  $nombre Nombre del cliente
     * @param string  $email  Correo del cliente
     * @param boolean $activo Estado del cliente
     */
    public function __construct($id, $nombre, $email, $activo = true)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->activo = $activo;
    }

    /**
     * Obtiene el nombre del cliente
     *
     * @return string Nombre del cliente
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del cliente
     *
     * @param string $nombre Nuevo nombre
     *
     * @return void
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
