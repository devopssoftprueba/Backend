<?php

/**
 * Conexión a la base de datos.
 *
 * @category Config
 * @package  Database
 * @author   Ronald Pelaez
 * @version  1.0.0
 * @since    1.0.0
 */

$host = 'localhost';
$db   = 'nombre_de_la_base_de_datos';
$user = 'usuario';
$pass = 'contraseña';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    /**
     * Objeto PDO para la conexión.
     *
     * @return void
     */
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
