<?php

/**
 * Script: doc-fixer.php
 * Descripción: Corrige y genera automáticamente documentación PHPDoc en archivos PHP modificados.
 * Uso: Este script es llamado desde el hook pre-push y trabaja sobre los archivos modificados.
 */

/**
 * Genera la documentación PHPDoc para una función.
 *
 * @param string $nombre  Nombre de la función.
 * @param array  $params  Lista de nombres de parámetros.
 * @param string $retorno Tipo de retorno de la función (por defecto: 'void').
 * @return string Retorna el bloque de documentación generado.
 */
function generarDocFuncion(string $nombre, array $params, string $retorno = 'void'): string
{
    $doc = "/**\n";
    $doc .= " * [Descripción pendiente por completar]\n";
    foreach ($params as $param) {
        $doc .= " * @param mixed \$$param Descripción del parámetro.\n";
    }
    $doc .= " * @return $retorno Descripción del valor retornado.\n";
    $doc .= " */\n";
    return $doc;
}

/**
 * Genera la documentación PHPDoc para una propiedad.
 *
 * @param string $nombre Nombre de la propiedad.
 * @return string Retorna el bloque de documentación generado.
 */
function generarDocPropiedad(string $nombre): string
{
    return "/**\n * [Descripción de la propiedad]\n * @var mixed\n */\n";
}

/**
 * Genera la documentación PHPDoc para una clase.
 *
 * @param string $nombre Nombre de la clase.
 * @return string Retorna el bloque de documentación generado.
 */
function generarDocClase(string $nombre): string
{
    return "/**\n * [Descripción de la clase $nombre]\n */\n";
}

/**
 * Procesa un archivo PHP para generar o corregir bloques de documentación PHPDoc.
 *
 * @param string $archivo Ruta del archivo a procesar.
 * @return void
 */
function procesarArchivo(string $archivo): void
{
    if (!file_exists($archivo)) {
        echo "⚠️ Archivo no encontrado: $archivo\n";
        return;
    }

    $contenido = file_get_contents($archivo);
    $lineas = explode("\n", $contenido);
    $nuevaSalida = [];
    $i = 0;
    $modificado = false;

    while ($i < count($lineas)) {
        $linea = $lineas[$i];

        // Validar clase
        if (preg_match('/^\s*(final\s+)?class\s+(\w+)/', $linea, $match)) {
            if ($i === 0 || !preg_match('/\*\//', $lineas[$i - 1])) {
                $nuevaSalida[] = generarDocClase($match[2]);
                $modificado = true;
            }
        }

        // Validar propiedad
        if (preg_match('/^\s*(public|protected|private)\s+\$[\w]+[ ;=]/', $linea)) {
            if ($i === 0 || !preg_match('/\*\//', $lineas[$i - 1])) {
                $nuevaSalida[] = generarDocPropiedad('');
                $modificado = true;
            }
        }

        // Validar función
        if (preg_match('/^\s*(public|protected|private)?\s*function\s+(\w+)\s*\((.*?)\)/', $linea, $match)) {
            if ($i === 0 || !preg_match('/\*\//', $lineas[$i - 1])) {
                $parametros = array_filter(array_map(function ($p) {
                    return trim(preg_replace('/.*\$/', '', $p));
                }, explode(',', $match[3])));
                $nuevaSalida[] = generarDocFuncion($match[2], $parametros);
                $modificado = true;
            }
        }

        $nuevaSalida[] = $linea;
        $i++;
    }

    if ($modificado) {
        file_put_contents($archivo, implode("\n", $nuevaSalida));
        echo "✅ Documentación corregida o agregada en: $archivo\n";
    } else {
        echo "✔️ Documentación ya válida en: $archivo\n";
    }
}
