<?php

namespace Models;

/**
 * Class Cliente
 *
 * Clase que representa un cliente en el sistema.
 *
 * @category Models
 * @package  App\Models
 * @author   Ronald
 * @version  1.0
 * @since    Archivo disponible desde la versión 1.0
 */

class Cliente //esta clase esta siendo agregada de manera local, no debe fallar la automatizacion
{
    /**
     * Identificador único del cliente.
     *
     * @var integer
     */
    private $id;

    /**
     * Nombre completo del cliente.
     *
     * @var string $nombre Nombre del cliente.
     */
    private $nombre;

    /**
     * Obtiene el nombre del cliente.
     *
     * @return string Nombre del cliente.
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
