<?php

require_once __DIR__ . '/doc-fixer.php';

// Archivos pasados desde el pre-push
$archivos = array_slice($argv, 1);

if (!empty($archivos)) {
    foreach ($archivos as $archivo) {
        if (file_exists($archivo)) {
            processFile($archivo);
        } else {
            echo "[ADVERTENCIA] Archivo no encontrado: $archivo\n";
        }
    }
} else {
    // Si no se especificaron archivos, se procesan todos los del proyecto
    ejecutarDocFixer();
}
