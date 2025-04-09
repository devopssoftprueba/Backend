<?php

/**
 * Script para analizar y documentar automáticamente código PHP con PHPDoc
 * conforme a una plantilla personalizada estricta para clases, métodos y propiedades.
 *
 * @author Ronald
 * @since  2025-04-09
 */

declare(strict_types=1);

/**
 * Procesa todos los archivos PHP dentro del proyecto y les aplica documentación PHPDoc.
 *
 * @return void
 */
function ejecutarDocFixer(): void
{
    $dir = __DIR__ . '/../'; // Ruta raíz del proyecto
    $phpFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($phpFiles as $file) {
        if ($file->getExtension() === 'php') {
            processFile($file->getPathname());
        }
    }
}

/**
 * Procesa un archivo PHP y agrega la documentación PHPDoc
 * a clases, propiedades y métodos si no la tienen.
 *
 * @param string $filePath Ruta del archivo a procesar.
 *
 * @return void
 */
function processFile(string $filePath): void
{
    $content = file_get_contents($filePath);

    // Procesar clases
    $content = preg_replace_callback(
        '/(class\s+(\w+)\s*(?:extends\s+\w+)?\s*\{)/',
        function ($matches) {
            $className = $matches[2];
            $fecha = date('Y-m-d');

            $docBlock = <<<EOD
/**
 * Clase $className.
 *
 * Esta clase representa la entidad $className y contiene sus métodos y propiedades asociadas.
 *
 * @category   Utilidades
 * @package    CustomModules
 * @author     Desconocido
 * @version    1.0.0
 * @since      $fecha
 */
EOD;
            return $docBlock . "\n" . $matches[0];
        },
        $content
    );

    // Procesar propiedades
    $content = preg_replace_callback(
        '/(private|protected|public)\s+\$([a-zA-Z0-9_]+)\s*;/',
        function ($matches) {
            $visibility = $matches[1];
            $name = $matches[2];

            return <<<EOD
/**
 * Propiedad \$$name.
 *
 * @var mixed Descripción no definida.
 */
$visibility \$$name;
EOD;
        },
        $content
    );

    // Procesar métodos
    $content = preg_replace_callback(
        '/(public|protected|private)\s+function\s+(\w+)\s*\(([^)]*)\)(\s*:\s*\??\w+)?\s*\{/',
        function ($matches) {
            $visibility = $matches[1];
            $name = $matches[2];
            $params = trim($matches[3]);
            $returnType = $matches[4] ?? '';
            $paramLines = '';

            if ($params !== '') {
                $paramsArray = explode(',', $params);
                foreach ($paramsArray as $param) {
                    preg_match('/(\??\w+)?\s*\$([\w_]+)/', trim($param), $pMatch);
                    $type = $pMatch[1] ?? 'mixed';
                    $pname = $pMatch[2] ?? 'param';
                    $paramLines .= " * @param $type \$$pname Descripción del parámetro.\n";
                }
            }

            $return = 'void';
            if (trim($returnType)) {
                $return = str_replace([':', '?'], '', trim($returnType));
            }

            return <<<EOD
/**
 * Método $name.
 *
 * Descripción del método $name.
$paramLines * @return $return Descripción del valor retornado.
 */
$visibility function $name($params)$returnType {
EOD;
        },
        $content
    );

    file_put_contents($filePath, $content);
}
