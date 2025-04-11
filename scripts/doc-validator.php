<?php

/**
 * Script para validar la documentación PHPDoc en archivos PHP sin modificar la
 * documentación ya existente.
 *
 * Este script escanea los archivos y verifica que las declaraciones de clases,
 * métodos y propiedades tengan un docblock inmediatamente antes (ignorando tokens
 * de espacio en blanco y comentarios en línea). Si falta el docblock, se reporta como error.
 *
 * La idea es que se ejecute en el hook pre-push para bloquear el push si algún bloque
 * nuevo o modificado carece de documentación.
 *
 * @author Ronald
 * @since  2025-04-10
 */

if ($argc < 2) {
    echo "Error: Debe especificarse al menos un archivo a validar.\n";
    exit(1);
}

$errors = [];
$filesToValidate = array_slice($argv, 1);

foreach ($filesToValidate as $filePath) {
    if (!file_exists($filePath)) {
        echo "Advertencia: El archivo no existe: {$filePath}\n";
        continue;
    }

    $code = file_get_contents($filePath);
    $tokens = token_get_all($code);
    $lineErrors = []; // errores en el archivo

    $docFound = false; // Indica que se encontró un docblock que puede servir para la siguiente declaración
    $i = 0;
    $len = count($tokens);

    while ($i < $len) {
        $token = $tokens[$i];
        if (is_array($token)) {
            $id = $token[0];
            $text = $token[1];
            $line = $token[2] ?? 'desconocida';

            // Si se encuentra un docblock, lo marcamos y avanzamos
            if ($id === T_DOC_COMMENT) {
                $docFound = true;
                $i++;
                continue;
            }

            // Si el token es espacio en blanco o un comentario de línea, se ignoran
            if (in_array($id, [T_WHITESPACE, T_COMMENT])) {
                $i++;
                continue;
            }

            // Si encontramos una declaración de clase
            if ($id === T_CLASS) {
                if (!$docFound) {
                    $lineErrors[] = "Línea {$line}: La declaración de la clase no tiene docblock.";
                }
                $docFound = false;
            }

            // Si encontramos una declaración de función
            if ($id === T_FUNCTION) {
                if (!$docFound) {
                    $lineErrors[] = "Línea {$line}: La declaración de la función no tiene docblock.";
                }
                $docFound = false;
            }

            // Si encontramos una propiedad (T_VARIABLE) en el ámbito de una clase y no dentro de una función,
            // asumiremos que debe tener docblock.
            // Para simplificar, no se verifica contexto exacto (ya que podría ser variable local de metodo).
            if ($id === T_VARIABLE) {
                if (!$docFound) {
                    $lineErrors[] = "Línea {$line}: La propiedad {$text} no tiene docblock.";
                }
                $docFound = false;
            }

            // Para cualquier otro token, reseteamos el indicador
            $docFound = false;
        }
        $i++;
    }

    if (!empty($lineErrors)) {
        $errors[$filePath] = $lineErrors;
    }
}

if (!empty($errors)) {
    echo "Errores de documentación detectados:\n";
    foreach ($errors as $file => $errs) {
        echo "Archivo: {$file}\n";
        foreach ($errs as $err) {
            echo "  - {$err}\n";
        }
        echo "\n";
    }
    exit(1);
} else {
    echo "Todos los archivos cuentan con la documentación necesaria.\n";
    exit(0);
}
