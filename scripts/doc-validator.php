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
     * @return array<string, array<int, int>> Arreglo de números de línea por archivo.
     */
    public function getModifiedLineNumbersByFile(): array
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

            if ($currentFile && preg_match('/^@@ \+\d+(?:,\d+)? @@/', $line)) {
                preg_match('/\+(\d+)/', $line, $match);
                $lineNumber = isset($match[1]) ? (int)$match[1] : null;
                if ($lineNumber !== null) {
                    $modified[$currentFile][] = $lineNumber;
                }
            }
        }

        return $modified;
    }

    /**
     * Valida si las líneas nuevas tienen documentación PHPDoc correspondiente.
     *
     * @param string $filePath    Ruta del archivo.
     * @param array  $lineNumbers Líneas modificadas en ese archivo.
     *
     * @return array Errores encontrados.
     */
    public function validatePHPDoc(string $filePath, array $lineNumbers): array
    {
        $errors = [];

        if (!file_exists($filePath)) {
            return [];
        }

        $code = file_get_contents($filePath);
        $tokens = token_get_all($code);
        $lineSet = array_flip($lineNumbers);

        for ($i = 0; $i < count($tokens); $i++) {
            $token = $tokens[$i];
            if (!is_array($token)) {
                continue;
            }

            [$id, $text, $line] = $token;

            if (isset($lineSet[$line])) {
                switch ($id) {
                    case T_CLASS:
                        if (!$this->hasValidDocBlock($tokens, $i)) {
                            $errors[] = "Línea {$line}: La clase no tiene docblock válido.";
                        }
                        break;

                    case T_FUNCTION:
                        if (!$this->hasValidDocBlock($tokens, $i)) {
                            $errors[] = "Línea {$line}: La función o método no tiene docblock válido.";
                        }
                        break;

                    case T_VARIABLE:
                        if (!$this->hasValidDocBlock($tokens, $i)) {
                            $errors[] = "Línea {$line}: La propiedad {$text} no tiene docblock válido.";
                        }
                        break;
                }
            }
        }

        return $errors;
    }

    /**
     * Verifica si hay un docblock inmediatamente antes del token actual.
     *
     * @param array   $tokens Arreglo con todos los tokens del archivo.
     * @param integer $index  Índice actual del token a analizar.
     *
     * @return boolean
     */
    private function hasValidDocBlock(array $tokens, int $index): bool
    {
        for ($j = $index - 1; $j >= 0; $j--) {
            if (!is_array($tokens[$j])) {
                continue;
            }

            if (in_array($tokens[$j][0], [T_WHITESPACE, T_PUBLIC, T_PRIVATE, T_PROTECTED, T_STATIC])) {
                continue;
            }

            if ($tokens[$j][0] === T_DOC_COMMENT) {
                return true;
            }

            break;
        }

        return false;
    }

    /**
     * Ejecuta la validación.
     *
     * @return void
     */
    public function run(): void
    {
        $modified = $this->getModifiedLineNumbersByFile();
        $hasErrors = false;

        foreach ($modified as $file => $lineNumbers) {
            if (!str_ends_with($file, '.php')) {
                continue;
            }

            echo "➡️ Validando {$file}...\n";
            $errors = $this->validatePHPDoc($file, $lineNumbers);

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

        if ($hasErrors) {
            echo "❌ El push fue bloqueado por errores de documentación.\n";
            exit(1);
        }

        echo "✅ Validación completada sin errores.\n";
        exit(0);
    }
    /**
     * Escribe un mensaje en el log.
     *
     * @param string $message Mensaje a registrar.
     *
     * @return void
     */
    private function log(string $message): void
    {
        $timestamp = date('[Y-m-d H:i:s]');
        file_put_contents(__DIR__ . '/logs/doc-validator.log', "{$timestamp} {$message}\n", FILE_APPEND);
    }
}
