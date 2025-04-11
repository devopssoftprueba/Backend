<?php

namespace App\Models;

/**
 * Clase Prueba
 *
 * Clase de prueba mínima para validaciones de documentación PHPDoc.
 *
 * @category Models
 * @package  App\Models
 * @author   Ronald
 * @version  1.0
 * @since    1.0
 */
class Prueba
{
    /**
     * Identificador de prueba
     *
     * @var integer
     */
    private int $id;

    /**
     * Obtener el ID de prueba
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }
}
