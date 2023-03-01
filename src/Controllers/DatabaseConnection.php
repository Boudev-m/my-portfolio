<?php
// DATABASE CONNECTION : Fichier de configuration de connexion à la BDD MySQL Portfolio avec PDO (PHP Data Objects)
namespace App\Controllers;

use PDO;

// Model POSTREPOSITORY
class DatabaseConnection
{
    private const DB_HOST = "localhost";
    private const DB_NAME = "portfolio";
    private const DB_USER = "root";
    private const DB_PASSWORD = "";

    public function getConnection(): PDO
    {
        $pdo = new PDO('mysql:host=' . $this::DB_HOST . ';charset=utf8mb4;dbname=' . $this::DB_NAME, $this::DB_USER, $this::DB_PASSWORD);
        return $pdo;
    }
}
