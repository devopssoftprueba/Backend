<?php
/**
 * Archivo de ejemplo para funciones anónimas
 */
// Ejemplo 1: Función anónima con array_map
$numeros = [1, 2, 3, 4, 5];
$duplicados = array_map(function($numero) {
    return $numero * 2;
}, $numeros);

// Ejemplo 2: Función anónima como callback
$usuarios = ['Juan', 'Ana', 'Pedro'];
array_walk($usuarios, function($nombre) {
    echo "Hola $nombre\n";
});

// Ejemplo 3: Función anónima con use
$multiplicador = 3;
$multiplicados = array_map(function($numero) use ($multiplicador) {
    return $numero * $multiplicador;
}, $numeros);

// Ejemplo 4: Función anónima como variable
$filtrar = function($valor) {
    return $valor > 3;
};
$filtrados = array_filter($numeros, $filtrar);

// Ejemplo 5: Función anónima en array_reduce
$suma = array_reduce($numeros, function($acumulador, $valor) {
    return $acumulador + $valor;
}, 0);

// Ejemplo 6: Función anónima como callback de ordenamiento
$frutas = ['manzana verde', 'pera', 'banana'];
usort($frutas, function($a, $b) {
    return strlen($a) - strlen($b);
});