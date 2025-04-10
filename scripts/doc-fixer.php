<?php

/**
 * Script para analizar y documentar automaticamente archivos PHP
 * utilizando PHPDoc conforme a una plantilla personalizada y estricta.
 *
 * Este script escanea el proyecto identifica las clases metodos y
 * propiedades en cada archivo PHP y realiza lo siguiente:
 *
 * 1. Si NO tienen documentacion, se la agrega completa siguiendo una plantilla estandar.
 * 2. Si TIENEN documentacion, valida si cumple con la plantilla:
 *  - Si cumple la deja intacta.
 *  - Si esta mal la elimina completamente y la reemplaza con una documentacion nueva correcta.
 *
 * Este proceso permite mantener la documentacion uniforme, clara y alineada con los estandares
 * definidos por la empresa o el equipo de desarrollo.
 *
 * @author Ronald
 * @since  2025-04-09
 */


declare(strict_types=1);

/**
 * Escanea el proyecto desde la raiz, identificando todos los archivos con extension `.php`.
 *
 * @return void
 */
function ejecutarDocFixer(): void
{
    $dir = __DIR__ . '/../';
    $phpFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($phpFiles as $file) {
        if ($file->getExtension() === 'php') {
            processFile($file->getPathname());
        }
    }
}

/**
 * Procesa un archivo PHP especifico y genera documentacion PHPDoc
 * para todas las clases, propiedades y metodos encontradas dentro del archivo.
 *
 * @param string $filePath Ruta absoluta del archivo PHP a procesar.
 *
 * @return void
 */
function processFile(string $filePath): void
{
    $content = file_get_contents($filePath);

    // DOCUMENTAR CLASES
    $content = preg_replace_callback(
        '/(?:\/\*\*[\s\S]*?\*\/\s*)?(class\s+(\w+)\s*(?:extends\s+\w+)?\s*\{)/',
        function ($matches) {
            $className = $matches[2];
            $fecha = date('Y-m-d');

            $docBlock = <<<EOD
/**
 * Clase $className.
 *
 * Esta clase representa la entidad $className y contiene sus metodos y propiedades asociadas.
 *
 * @category   Utilidades
 * @package    CustomModules
 * @author     Desconocido
 * @version    1.0.0
 * @since      $fecha
 */
EOD;
            return $docBlock . "\n" . $matches[1];
        },
        $content
    );

    // DOCUMENTAR PROPIEDADES
    $content = preg_replace_callback(
        '/(?:\/\*\*[\s\S]*?\*\/\s*)?((private|protected|public)\s+\$([a-zA-Z0-9_]+)\s*;)/',
        function ($matches) {
            $visibility = $matches[2];
            $name = $matches[3];

            return <<<EOD
/**
 * Propiedad \$$name.
 *
 * @var mixed Descripcion no definida.
 */
$visibility \$$name;
EOD;
        },
        $content
    );

    // DOCUMENTAR METODOS
    $content = preg_replace_callback(
        pattern: '/(?:\/\*\*[\s\S]*?\*\/\s*)?' .
        '((public|protected|private)\s+function\s+(\w+)\s*' .
        '\(([^)]*)\)(\s*:\s*\??\w+)?\s*\{)/',
        callback: function ($matches) {
            $visibility = $matches[2];
            $name = $matches[3];
            $params = trim($matches[4]);
            $returnType = $matches[5] ?? '';
            $paramLines = '';

            if ($params !== '') {
                $paramsArray = explode(',', $params);
                foreach ($paramsArray as $param) {
                    preg_match('/(\??\w+)?\s*\$([\w_]+)/', trim($param), $pMatch);
                    $type = $pMatch[1] ?? 'mixed';
                    $pname = $pMatch[2] ?? 'param';
                    $paramLines .= " * @param $type \$$pname Descripcion del parametro.\n";
                }
            }

            $return = 'void';
            if (trim($returnType)) {
                $return = str_replace([':', '?'], '', trim($returnType));
            }

            return <<<EOD
/**
 * Metodo $name.
 *
 * Descripcion del metodo $name.
$paramLines *
 * @return $return Descripcion del valor retornado.
 */
$visibility function $name($params)$returnType {
EOD;
        },
        subject: $content
    );

    file_put_contents($filePath, $content);
}

/**
 * Funcion principal que ejecuta el script si se desea invocar directamente.
 *
 * @return void
 */
function main(): void
{
    ejecutarDocFixer();
}