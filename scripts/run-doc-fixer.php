<?php

require_once __DIR__ . '/doc-fixer.php';

// Archivos pasados desde el pre-push
$archivos = array_slice($argv, 1);
foreach ($archivos as $archivo) {
    procesarArchivo($archivo);
}
