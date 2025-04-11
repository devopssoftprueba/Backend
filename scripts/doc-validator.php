<?php

/**
 * Script para validar la documentación PHPDoc en archivos PHP sin modificar la documentación ya existente.
 *
 * Este script escanea los archivos y verifica que las declaraciones
 * de clases, métodos y propiedades tengan un docblock antes de ellos.
 * Si falta el docblock se reporta como error.
 *
 * La idea es que se ejecute en el hook pre-push para que, si algún bloque
 * nuevo o modificado carece de documentación, el push se bloquee.
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
    $lineErrors = []; // errores del archivo

    $prevTokenWasDoc = false;
    $insideClass = false;
    $insideFunction = false;

    // Recorremos los tokens para buscar declaraciones importantes
    for ($i = 0, $len = count($tokens); $i < $len; $i++) {
        $token = $tokens[$i];
        if (is_array($token)) {
            $id = $token[0];
            $text = $token[1];
            $line = $token[2] ?? 'desconocida';

            // Si encontramos un docblock, lo registramos
            if ($id === T_DOC_COMMENT) {
                $prevTokenWasDoc = true;
                continue;
            }

            // Detectar declaración de clase
            if ($id === T_CLASS) {
                $insideClass = true;
                if (!$prevTokenWasDoc) {
                    $lineErrors[] = "Línea {$line}: La declaración de la clase no tiene docblock.";
                }
                $prevTokenWasDoc = false;
            }

            // Detectar declaración de función
            if ($id === T_FUNCTION) {
                $insideFunction = true;
                if (!$prevTokenWasDoc) {
                    $lineErrors[] = "Línea {$line}: La declaración de la función no tiene docblock.";
                }
                $prevTokenWasDoc = false;
            }

            // Detectar propiedades: si se encuentra T_VARIABLE y el token anterior fue una declaración de visibilidad
            if ($id === T_VARIABLE && $insideClass && !$insideFunction) {
                // Buscamos si antes de la propiedad hay un docblock
                if (!$prevTokenWasDoc) {
                    $lineErrors[] = "Línea {$line}: La propiedad {$text} no tiene docblock.";
                }
                $prevTokenWasDoc = false;
            }

            // Resetear si el token no es T_DOC_COMMENT; esto nos indica que el docblock ya fue evaluado
            if ($id !== T_DOC_COMMENT) {
                $prevTokenWasDoc = false;
            }
        }
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
