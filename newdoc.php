<?php

namespace App\Models;

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
