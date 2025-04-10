<?php

/**
 * Script de ejecución para la documentación automática PHPDoc.
 *
 * Este archivo carga las funciones desde `doc-fixer.php`
 * y ejecuta el proceso ya sea sobre archivos específicos
 * o sobretodo
 * el proyecto si no se pasan argumentos.
 */

require_once __DIR__ . '/doc-fixer.php';

// Obtener archivos pasados como argumentos desde el hook pre-push
$archivos = array_slice($argv, 1);

if (!empty($archivos)) {
    foreach ($archivos as $archivo) {
        if (file_exists($archivo)) {
            echo "[INFO] Procesando archivo: $archivo\n";
            processFile($archivo);
        } else {
            echo "[ADVERTENCIA] Archivo no encontrado: $archivo\n";
        }
    }
} else {
    echo "[INFO] Procesando todos los archivos del proyecto...\n";
    ejecutarDocFixer();
}
