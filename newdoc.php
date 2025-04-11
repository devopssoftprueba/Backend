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
    /**
     * Establece el ID de prueba
     *
     * Asigna un nuevo valor al identificador de prueba.
     *
     * @param integer
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
