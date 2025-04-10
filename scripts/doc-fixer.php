<?php

/**
 * Script para analizar y documentar automáticamente archivos PHP
 * utilizando PHPDoc conforme a una plantilla personalizada y estricta.
 *
 * Este script escanea el proyecto, identifica las clases, métodos y propiedades
 * en cada archivo PHP y realiza lo siguiente:
 *
 * 1. Si no tienen documentación, se la agrega completa siguiendo una plantilla estándar.
 * 2. Si tienen documentación, valida si cumple con la plantilla:
 *    - Si cumple, la deja intacta.
 *    - Si está mal, la elimina completamente y la reemplaza con una nueva.
 *
 * Este proceso permite mantener la documentación uniforme, clara y alineada con los estándares
 * definidos por la empresa o el equipo de desarrollo.
 *
 * @author Ronald
 * @since  2025-04-10
 */

$directory = __DIR__ . '/../src/';
$phpFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$log = [];

foreach ($phpFiles as $file) {
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $filePath = $file->getRealPath();
    $originalCode = file_get_contents($filePath);
    $tokens = token_get_all($originalCode);

    $newCode = '';
    $buffer = '';
    $isInDocBlock = false;
    $className = '';
    $insideClass = false;
    $insideFunction = false;
    $namespace = '';
    $lastVisibility = null;

    foreach ($tokens as $token) {
        if (is_array($token)) {
            [$id, $text] = $token;

            // Capturar namespace
            if ($id === T_NAMESPACE) {
                $buffer = 'namespace';
                $newCode .= $text;
                continue;
            }

            if ($id === T_STRING && $buffer === 'namespace') {
                $namespace .= trim($text);
                $buffer = '';
            }

            // Eliminar docblocks mal formados (solo los que no tengan @category, etc.)
            if ($id === T_DOC_COMMENT && !preg_match('/@(?:category|package|author|version|since)/', $text)) {
                $isInDocBlock = true;
                continue;
            }

            // Capturar visibilidad de propiedades
            if (in_array($id, [T_PUBLIC, T_PRIVATE, T_PROTECTED])) {
                $lastVisibility = $text;
                $newCode .= $text;
                continue;
            }

            // Guardar nombre de clase justo después de T_CLASS
            if ($id === T_CLASS) {
                $insideClass = true;
                $buffer = '';
                $newCode .= $text;
                continue;
            }

            // Capturar nombre de la clase después de T_CLASS
            if ($insideClass && $id === T_STRING && $className === '') {
                $className = $text;

                // Documentar clase justo después de capturar nombre
                $classDoc  = "\n\n    /**\n";
                $classDoc .= "     * Clase {$className}.\n";
                $classDoc .= "     *\n";
                $classDoc .= "     * Esta clase representa un modelo dentro del sistema.\n";
                $classDoc .= "     *\n";
                $classDoc .= "     * @category {$namespace}\n";
                $classDoc .= "     * @package  {$namespace}\n";
                $classDoc .= "     * @author   Ronald\n";
                $classDoc .= "     * @version  1.0\n";
                $classDoc .= "     * @since    2025-04-10\n";
                $classDoc .= "     */";

                $newCode .= $classDoc;
                $newCode .= $text;
                continue;
            }

            // Detectar entrada a función
            if ($id === T_FUNCTION) {
                $insideFunction = true;
                $lastVisibility = null;
                $newCode .= $text;
                continue;
            }

            // Detectar cierre de función
            if ($text === '}') {
                $insideFunction = false;
            }

            // Detectar propiedades (fuera de funciones)
            if ($insideClass && !$insideFunction && $id === T_VARIABLE && $lastVisibility !== null) {
                $varName = trim($text, '$');
                $type = 'mixed';

                $propLine  = "\n\n    /**\n";
                $propLine .= "     * {$varName} del modelo.\n";
                $propLine .= "     *\n";
                $propLine .= "     * @var {$type} \${$varName} Descripcion del atributo.\n";
                $propLine .= "     */";

                $newCode .= $propLine;
                $newCode .= "\n    " . $lastVisibility . ' ' . $text;

                $lastVisibility = null;
                continue;
            }

            $newCode .= $text;
        } else {
            if (!$isInDocBlock) {
                $newCode .= $token;
            } else {
                $isInDocBlock = false;
            }
        }
    }

    if ($newCode !== $originalCode) {
        file_put_contents($filePath, $newCode);
        $log[] = "📄 Archivo corregido: {$filePath}";
    }
}

echo "📋 RESUMEN DE DOCUMENTACION AUTOMATICA\n";
foreach ($log as $entry) {
    echo $entry . "\n";
}
