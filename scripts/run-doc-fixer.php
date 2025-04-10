<?php

/**
 * Script que ejecuta la documentación automática sobre todos los archivos del proyecto,
 * incluyendo validación con PHPCS y PHPCBF.
 *
 * @author Ronald
 * @since  2025-04-10
 */

$basePath = __DIR__ . '/../';
$sourcePath = $basePath . 'src/';
$scriptPath = $basePath . 'scripts/doc-fixer.php';

$phpFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));

$erroresPendientes = [];
$archivosValidos = [];

foreach ($phpFiles as $file) {
    if (
        $file->getExtension() !== 'php' ||
        str_contains($file->getRealPath(), 'vendor') ||
        str_contains($file->getRealPath(), 'tests') ||
        str_contains($file->getRealPath(), 'config') ||
        str_contains($file->getRealPath(), '.git')
    ) {
        continue;
    }

    $path = $file->getRealPath();
    echo "📂 Procesando archivo: " . str_replace($basePath, '', $path) . PHP_EOL;

    echo "📄 Ejecutando scripts de documentación automática en: " . str_replace($basePath, '', $path) . PHP_EOL;
    passthru("php {$scriptPath} \"{$path}\"", $docResultCode);

    echo "🛠️ Resultado de corrección automática:" . PHP_EOL;
    if ($docResultCode !== 0) {
        echo "❌ Error durante la documentación automática." . PHP_EOL;
    } else {
        echo "🛠️ Documentación corregida o agregada." . PHP_EOL;
    }

    echo "🔍 Ejecutando PHPCBF..." . PHP_EOL;
    passthru("vendor/bin/phpcbf \"{$path}\"");

    echo "✅ Ejecutando PHPCS..." . PHP_EOL;
    ob_start();
    passthru("vendor/bin/phpcs \"{$path}\"", $phpcsCode);
    $phpcsOutput = ob_get_clean();
    echo $phpcsOutput;

    if ($phpcsCode !== 0) {
        $erroresPendientes[] = str_replace($basePath, '', $path);
    } else {
        $archivosValidos[] = str_replace($basePath, '', $path);
    }
}

echo "📋 RESUMEN FINAL DEL PROCESO" . PHP_EOL;
echo "─────────────────────────────" . PHP_EOL;

if (!empty($archivosValidos)) {
    echo "✅ Archivos válidos sin necesidad de modificación:" . PHP_EOL;
    foreach ($archivosValidos as $file) {
        echo "   - {$file}" . PHP_EOL;
    }
}

if (!empty($erroresPendientes)) {
    echo "❌ Archivos con errores pendientes:" . PHP_EOL;
    foreach ($erroresPendientes as $file) {
        echo "   - {$file}" . PHP_EOL;
    }

    echo "🚫 Push cancelado. Debes corregir los errores antes de continuar." . PHP_EOL;
    exit(1);
}

echo "🎉 Todos los archivos están correctos. Puedes hacer push sin problemas." . PHP_EOL;
exit(0);
