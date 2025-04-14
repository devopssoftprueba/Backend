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
class Calculator
{
    /**
     * Suma dos números.
     *
     * @param  $a Primer número.
     * @param  $b Segundo número.
     *
     * @return  Resultado de la suma.
     */
    public function add($a, $b)
    {
        return $a + $b;
    }

    /**
     * Resta dos números.
     *
     * @param mixed $a Primer número.
     * @param mixed $b Segundo número.
     *
     * @return mixed Resultado de la resta.
     */
    public function subtract($a, $b)
    {
        return $a - $b;
    }
}
