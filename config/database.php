<?php

/**
 * Archivo de conexión a la base de datos MySQL.
 *
 * @package Backend
 * @author Ronald
 * @version 1.0
 * @since 2025-04-06
 */

function getPDO(): PDO
{
    $host = 'localhost';
    $dbname = 'virtualstore';
    $user = 'root';
    $password = ''; // Sin contraseña en XAMPP por defecto

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("❌ Error al conectar a la base de datos: " . $e->getMessage());
    }
}
