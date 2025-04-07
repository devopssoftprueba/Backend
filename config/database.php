<?php

/**
 * Configuración de la conexión a la base de datos.
 *
 * Este archivo establece y retorna una instancia de PDO para interactuar con la base de datos.
 */

declare(strict_types=1);

$host = 'localhost';
$db   = 'nombre_de_tu_base_de_datos';
$user = 'usuario';
$pass = 'contraseña';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    return new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
}
