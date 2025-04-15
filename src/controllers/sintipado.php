<?php

/**
 * Clase que representa operaciones matemáticas básicas.
 *
 * @category Utilities
 * @package  Utilities
 * @author   Ronald
 * @version  1.0
 * @since    Archivo disponible desde la versión 1.0
 */

class calc
{
    /**
     * Suma dos números.
     *
     * @param integer $a Primer numero.
     * @param integer $b Segundo numero.
     *
     * @return integer Resultado de la suma.
     */
    private function add(int $a, int $b)
    {
        return $a + $b;
    }

    /**
     * Resta dos números.
     *
     * @param integer $a Primer número.
     * @param integer $b Segundo número.
     *
     * @return mixed Resultado de la resta.
     */
    public function subtract($a, $b)
    {
        return $a - $b;
    }
}
