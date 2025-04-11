<?php

namespace script;

/**
 * Script para validar la documentación PHPDoc en declaraciones nuevas o modificadas.
 *
 * @category Validación
 * @package  DocumentaciónPHPDoc
 * @author   Ronald
 * @version  1.0
 * @since    2025-04-11
 */
class PHPDocValidator
{
    /**
     * Obtiene las líneas modificadas por archivo del último `git add`.
     *
     * @return array<string, array<int, string>> Arreglo de líneas modificadas por archivo.
     */
    public function getModifiedLinesByFile(): array
    {
        $output = [];
        exec('git diff --cached --unified=0 --no-color', $output);

        $modified = [];
        $currentFile = null;

        foreach ($output as $line) {
            if (preg_match('/^\+\+\+ b\/(.+)$/', $line, $matches)) {
                $currentFile = $matches[1];
                continue;
            }

            if ($currentFile !== null && str_starts_with($line, '+') && !str_starts_with($line, '+++')) {
                $modified[$currentFile][] = $line;
            }
        }

        return $modified;
    }

    /**
     * Valida si las líneas nuevas tienen documentación PHPDoc correspondiente.
     *
     * @param string $filePath      Ruta del archivo.
     * @param array  $modifiedLines Líneas modificadas en ese archivo.
     *
     * @return array Errores encontrados.
     */
    public function validatePHPDoc(string $filePath, array $modifiedLines): array
    {
        $errors = [];

        if (!file_exists($filePath)) {
            return [];
        }

        $code      = file_get_contents($filePath);
        $tokens    = token_get_all($code);
        $lineMap   = array_flip(array_map('trim', $modifiedLines));
        $lines     = explode("\n", $code);
        $lineNums  = [];

        foreach ($modifiedLines as $modLine) {
            $clean = ltrim($modLine, '+');
            foreach ($lines as $i => $line) {
                if (trim($line) === trim($clean)) {
                    $lineNums[] = $i + 1;
                    break;
                }
            }
        }

        $prevTokenWasDoc = false;
        $insideClass     = false;
        $insideFunction  = false;

        for ($i = 0, $len = count($tokens); $i < $len; $i++) {
            $token = $tokens[$i];
            if (!is_array($token)) {
                continue;
            }

            [$id, $text, $line] = $token;

            if (!in_array($line, $lineNums, true)) {
                continue;
            }

            if ($id === T_DOC_COMMENT) {
                $prevTokenWasDoc = true;
                continue;
            }

            if ($id === T_CLASS) {
                if (!$prevTokenWasDoc) {
                    $errors[] = "Línea {$line}: La clase no tiene docblock.";
                }
            }

            if ($id === T_FUNCTION) {
                if (!$prevTokenWasDoc) {
                    $errors[] = "Línea {$line}: La función o método no tiene docblock.";
                }
            }

            if ($id === T_VARIABLE && $insideClass && !$insideFunction) {
                if (!$prevTokenWasDoc) {
                    $errors[] = "Línea {$line}: La propiedad {$text} no tiene docblock.";
                }
            }

            $prevTokenWasDoc = false;
        }

        return $errors;
    }

    /**
     * Recorre los archivos modificados y valida la documentación donde aplique.
     *
     * @return void
     */
    public function run(): void
    {
        $modifiedByFile = $this->getModifiedLinesByFile();
        $hasErrors      = false;

        foreach ($modifiedByFile as $file => $lines) {
            if (!str_ends_with($file, '.php')) {
                continue;
            }

            echo "➡️ Validando {$file}...\n";
            $errors = $this->validatePHPDoc($file, $lines);

            if (!empty($errors)) {
                echo "❌ Errores detectados en {$file}:\n";
                foreach ($errors as $e) {
                    echo "  - {$e}\n";
                }

                $hasErrors = true;
            } else {
                echo "✅ {$file} validado correctamente.\n";
            }
        }

        if ($hasErrors === true) {
            echo "❌ El push fue bloqueado por errores de documentación.\n";
            exit(1);
        }

        exit(0);
    }
}

// Llamada al validador encapsulada como lógica separada (aceptada por PHPCS)
(new PHPDocValidator())->run();
