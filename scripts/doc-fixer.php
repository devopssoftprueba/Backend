<?php

/**
 * Script para analizar y documentar automáticamente archivos PHP
 * utilizando PHPDoc conforme a una plantilla personalizada y estricta.
 *
 * Este script escanea el proyecto, identifica las clases, métodos y propiedades
 * en cada archivo PHP y realiza lo siguiente:
 *
 * 1. Si no tienen documentación, se la agrega completa siguiendo una plantilla estándar.
 * 2. Si ya tienen documentación (aunque esté mal), la deja intacta.
 *
 * Esto permite que el script sea seguro para proyectos existentes, sin sobrescribir
 * documentación antigua.
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
    $className = '';
    $insideClass = false;
    $insideFunction = false;
    $namespace = '';
    $lastVisibility = null;
    $prevToken = null;

    foreach ($tokens as $token) {
        if (is_array($token)) {
            [$id, $text] = $token;

            // Capturar namespace
            if ($id === T_NAMESPACE) {
                $newCode .= $text;
                continue;
            }

            if ($id === T_STRING && $prevToken === T_NAMESPACE) {
                $namespace .= trim($text);
            }

            // Guardar nombre de clase justo después de T_CLASS
            if ($id === T_CLASS) {
                $insideClass = true;
                $newCode .= $text;
                continue;
            }

            // Capturar nombre de la clase
            if ($insideClass && $id === T_STRING && $className === '') {
                $className = $text;

                // Verificar si ya hay un docblock justo antes
                if (trim(substr($newCode, -3)) !== '*/') {
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
                }

                $newCode .= $text;
                continue;
            }

            // Detectar entrada a función
            if ($id === T_FUNCTION) {
                $insideFunction = true;
                $lastVisibility = null;

                // Verificar si ya hay un docblock antes
                if (trim(substr($newCode, -3)) !== '*/') {
                    $newCode .= "\n\n    /**\n";
                    $newCode .= "     * Descripción del método.\n";
                    $newCode .= "     *\n";
                    $newCode .= "     * @return void\n";
                    $newCode .= "     */";
                }

                $newCode .= $text;
                continue;
            }

            // Capturar visibilidad para propiedades
            if (in_array($id, [T_PUBLIC, T_PRIVATE, T_PROTECTED])) {
                $lastVisibility = $text;
                $newCode .= $text;
                continue;
            }

            // Detectar propiedades (fuera de funciones)
            if ($insideClass && !$insideFunction && $id === T_VARIABLE && $lastVisibility !== null) {
                $varName = trim($text, '$');
                $type = 'mixed';

                // Verificar si ya hay docblock antes
                if (trim(substr($newCode, -3)) !== '*/') {
                    $propLine  = "\n\n    /**\n";
                    $propLine .= "     * {$varName} del modelo.\n";
                    $propLine .= "     *\n";
                    $propLine .= "     * @var {$type} \${$varName} Descripcion del atributo.\n";
                    $propLine .= "     */";
                    $newCode .= $propLine;
                }

                $newCode .= "\n    " . $lastVisibility . ' ' . $text;
                $lastVisibility = null;
                continue;
            }

            $newCode .= $text;
            $prevToken = $id;
        } else {
            $newCode .= $token;
        }
    }

    if ($newCode !== $originalCode) {
        file_put_contents($filePath, $newCode);
        $log[] = "📄 Archivo documentado (solo bloques nuevos): {$filePath}";
    }
}

echo "📋 RESUMEN DE DOCUMENTACION (solo bloques nuevos)\n";
foreach ($log as $entry) {
    echo $entry . "\n";
}