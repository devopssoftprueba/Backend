<?php

declare(strict_types=1);

/**
 * PHPDocValidator
 *
 * Valida y genera bloques de documentación PHPDoc para clases, métodos y propiedades
 * nuevas o modificadas, según una plantilla personalizada.
 *
 * @category Validator
 * @package  PHPDocTools
 * @author   Ronald
 * @version  1.0
 * @since    2025-04-11
 */

class PHPDocValidator
{
    private const VALID_TAGS = ['@category', '@package', '@author', '@version', '@since'];
    private const VALID_VAR_TYPES = ['integer', 'string', 'boolean', 'float', 'array', 'mixed', 'callable'];

    /**
     * Ejecuta el proceso de validación y documentación automática
     */
    public function run(): void
    {
        echo "➡️ Obteniendo archivos PHP modificados...\n";
        $modifiedLines = $this->getModifiedLineNumbersByFile();

        if (empty($modifiedLines)) {
            echo "✅ No hay archivos PHP nuevos o modificados para validar.\n";
            return;
        }

        foreach ($modifiedLines as $file => $lines) {
            echo "📂 Procesando: {$file}\n";
            $content = file_get_contents($file);
            $tokens = token_get_all($content);
            $newContent = $this->processTokens($tokens, $lines, $file);
            file_put_contents($file, $newContent);
        }

        echo "✅ Validación y documentación completadas.\n";
    }

    /**
     * Detecta los archivos modificados y las líneas nuevas
     *
     * @return array<string, array<int>>
     */
    private function getModifiedLineNumbersByFile(): array
    {
        $modified = [];
        $output = [];

        exec('git diff --cached --name-status --diff-filter=AM', $output);

        foreach ($output as $line) {
            [$status, $file] = preg_split('/\s+/', $line, 2);
            if (!str_ends_with($file, '.php')) {
                continue;
            }

            if ($status === 'A') {
                $lineCount = count(file($file));
                $modified[$file] = range(1, $lineCount);
            } elseif ($status === 'M') {
                $diffOutput = [];
                exec("git diff --cached -U0 -- {$file}", $diffOutput);

                foreach ($diffOutput as $diffLine) {
                    if (preg_match('/^@@ \+(\d+)(?:,(\d+))? @@/', $diffLine, $matches)) {
                        $start = (int) $matches[1];
                        $count = isset($matches[2]) ? (int) $matches[2] : 1;
                        for ($i = $start; $i < $start + $count; $i++) {
                            $modified[$file][] = $i;
                        }
                    }
                }
            }
        }

        return $modified;
    }

    /**
     * Procesa los tokens PHP y actualiza los bloques PHPDoc
     *
     * @param array $tokens Todos los tokens.
     * @param array $lines Líneas nuevas/modificadas.
     * @param string $file Nombre del archivo.
     *
     * @return string Código actualizado.
     */
    private function processTokens(array $tokens, array $lines, string $file): string
    {
        $output = '';
        $lineMap = array_flip($lines);
        $tokenCount = count($tokens);
        $i = 0;

        while ($i < $tokenCount) {
            $token = $tokens[$i];

            if (is_array($token) && in_array($token[0], [T_CLASS, T_FUNCTION, T_VARIABLE], true)) {
                $line = $token[2];

                if (!isset($lineMap[$line])) {
                    $output .= is_array($token) ? $token[1] : $token;
                    $i++;
                    continue;
                }

                // Buscar y eliminar PHPDoc existente
                $docBlockIndex = $i - 2;
                if (isset($tokens[$docBlockIndex]) && is_array($tokens[$docBlockIndex]) && $tokens[$docBlockIndex][0] === T_DOC_COMMENT) {
                    $i = $docBlockIndex;
                }

                // Generar documentación nueva
                $type = token_name($token[0]);
                $doc = $this->generateDocBlock($type, $tokens, $i, $file);
                $output .= $doc;
            }

            $output .= is_array($token) ? $token[1] : $token;
            $i++;
        }

        return $output;
    }

    /**
     * Genera un bloque PHPDoc basado en el tipo de declaración
     *
     * @param string $type Tipo del token (T_CLASS, T_FUNCTION, T_VARIABLE)
     * @param array $tokens Todos los tokens
     * @param int $index índice actual del token.
     * @param string $file Ruta del archivo.
     *
     * @return string Bloque PHPDoc generado.
     */
    private function generateDocBlock(string $type, array $tokens, int $index, string $file): string
    {
        $indent = $this->getIndentation($tokens, $index);
        $lines = [];

        $lines[] = "{$indent}/**";

        switch ($type) {
            case 'T_CLASS':
                $lines[] = "{$indent} * Clase {$this->getTokenName($tokens, $index)}";
                foreach (self::VALID_TAGS as $tag) {
                    $lines[] = "{$indent} * {$tag}  ";
                }
                break;

            case 'T_FUNCTION':
                $lines[] = "{$indent} * Método {$this->getTokenName($tokens, $index)}";
                $params = $this->extractFunctionParams($tokens, $index);
                foreach ($params as $param) {
                    $lines[] = "{$indent} * @param {$param['type']} \${$param['name']} {$param['desc']}";
                }
                $lines[] = "{$indent} * @return array Resultado como array.";
                break;

            case 'T_VARIABLE':
                $name = ltrim($tokens[$index][1], '$');
                $lines[] = "{$indent} * Propiedad \${$name}";
                $lines[] = "{$indent} * @var integer Descripción breve.";
                break;
        }

        $lines[] = "{$indent} */";

        return implode("\n", $lines) . "\n";
    }

    /**
     * Extrae el nombre del token (clase o función)
     *
     * @param array $tokens Tokens.
     * @param int $index Índice del token.
     *
     * @return string
     */
    private function getTokenName(array $tokens, int $index): string
    {
        $i = $index + 1;
        while (isset($tokens[$i])) {
            if (is_array($tokens[$i]) && $tokens[$i][0] === T_STRING) {
                return $tokens[$i][1];
            }
            $i++;
        }
        return 'Desconocido';
    }

    /**
     * Extrae parámetros de una función
     *
     * @param array $tokens Tokens.
     * @param int $index Índice de la función.
     *
     * @return array<int, array{type: string, name: string, desc: string}>
     */
    private function extractFunctionParams(array $tokens, int $index): array
    {
        $params = [];
        $i = $index;
        while (isset($tokens[$i]) && $tokens[$i] !== '(') {
            $i++;
        }
        $i++;

        while (isset($tokens[$i]) && $tokens[$i] !== ')') {
            $type = 'mixed';
            $name = '';
            if (is_array($tokens[$i]) && $tokens[$i][0] === T_STRING) {
                $type = $tokens[$i][1];
                $i++;
            }
            while (isset($tokens[$i]) && $tokens[$i][0] !== T_VARIABLE) {
                $i++;
            }
            if (isset($tokens[$i]) && $tokens[$i][0] === T_VARIABLE) {
                $name = ltrim($tokens[$i][1], '$');
                $params[] = ['type' => $type, 'name' => $name, 'desc' => ''];
            }
            $i++;
        }

        return $params;
    }

    /**
     * Obtiene la indentación de la línea actual
     *
     * @param array $tokens Tokens.
     * @param int $index Índice actual.
     *
     * @return string
     */
    private function getIndentation(array $tokens, int $index): string
    {
        for ($i = $index - 1; $i >= 0; $i--) {
            if (is_array($tokens[$i]) && $tokens[$i][0] === T_WHITESPACE) {
                $lines = explode("\n", $tokens[$i][1]);
                return end($lines);
            }
        }
        return '';
    }
}
