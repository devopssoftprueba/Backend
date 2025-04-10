<?php

/**
 * Script para analizar y documentar automáticamente un archivo PHP
 * utilizando PHPDoc conforme a una plantilla personalizada y estricta.
 *
 * Este script:
 * 1. Valida si el archivo tiene documentación PHPDoc conforme a plantilla.
 * 2. Si no tiene, la genera.
 * 3. Si está mal, la reemplaza.
 * 4. Si está bien, no la toca.
 */

if ($argc < 2) {
    echo "❌ Debes proporcionar un archivo PHP a analizar.\n";
    exit(1);
}

$filePath = $argv[1];

if (!file_exists($filePath)) {
    echo "❌ El archivo no existe: $filePath\n";
    exit(1);
}

$originalCode = file_get_contents($filePath);
$tokens = token_get_all($originalCode);

$newCode = '';
$buffer = '';
$isInDocBlock = false;
$className = '';
$insideClass = false;
$namespace = '';
$modified = false;

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
            $modified = true;
            continue;
        }

        if ($id === T_CLASS) {
            $insideClass = true;
            $newCode .= "\n\n    /**\n     * Clase {$text}.\n     *\n     * Esta clase representa un modelo dentro del sistema.\n     *\n     * @category {$namespace}\n     * @package  {$namespace}\n     * @author   Ronald\n     * @version  1.0\n     * @since    2025-04-10\n     */";
            $modified = true;
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
            $modified = true;
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

if ($modified && $newCode !== $originalCode) {
    file_put_contents($filePath, $newCode);
    echo "🛠️ Documentación corregida o agregada.";
} else {
    echo "✅ Documentación ya estaba correcta. Sin cambios.";
}
