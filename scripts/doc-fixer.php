<?php

/**
 * Script para analizar y documentar automaticamente archivos PHP
 * utilizando PHPDoc conforme a una plantilla personalizada y estricta.
 *
 * Este script escanea todo el proyecto identifica las clases metodos y propiedades
 * en cada archivo PHP y realiza lo siguiente:
 *
 * 1. Si no tienen documentacion, se la agrega completa siguiendo una plantilla estandar.
 * 2. Si tienen documentacion, valida si cumple con la plantilla:
 *    - Si cumple, la deja intacta.
 *    - Si esta mal, la elimina completamente y la reemplaza con una nueva.
 *
 * Este proceso permite mantener la documentacion uniforme, clara y alineada con los estandares
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
    $namespace = '';

    foreach ($tokens as $token) {
        if (is_array($token)) {
            [$id, $text] = $token;

            // Capturar namespace
            if ($id === T_NAMESPACE) {
                $buffer = $text;
                continue;
            }

            if ($id === T_STRING && str_contains($buffer, 'namespace')) {
                $namespace .= trim($text);
                $buffer = '';
            }

            // Remover docblocks mal formados antes de clase/metodo/propiedad
            if ($id === T_DOC_COMMENT && !preg_match('/@(?:category|package|author|version|since)/', $text)) {
                $isInDocBlock = true;
                continue;
            }

            if ($id === T_CLASS) {
                $insideClass = true;
                $newCode .= "\n\n    /**\n     * Clase {$text}.\n     *\n     * Esta clase representa un modelo dentro del sistema.\n     *\n     * @category {$namespace}\n     * @package  {$namespace}\n     * @author   Ronald\n     * @version  1.0\n     * @since    2025-04-10\n     */";
            }

            if ($insideClass && $id === T_VARIABLE) {
                $varName = trim($text, '$');
                $type = 'mixed';
                if (str_contains($newCode, "private int \${$varName}")) {
                    $type = 'integer';
                } elseif (str_contains($newCode, "private string \${$varName}")) {
                    $type = 'string';
                } elseif (str_contains($newCode, "private float \${$varName}")) {
                    $type = 'float';
                }
                $newCode .= "\n\n    /**\n     * {$varName} del modelo.\n     *\n     * @var {$type} \${$varName} Descripcion del atributo.\n     */";
            }

            if ($id === T_FUNCTION) {
                $buffer = '';
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
