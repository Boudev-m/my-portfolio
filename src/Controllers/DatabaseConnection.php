<?php
// DATABASECONNECTION CONTROLLER
// Config controller to connect to 'Portfolio' MySQL database, using PDO (PHP Data Objects)

namespace App\Controllers;

use PDO;

class DatabaseConnection
{
    // DATABASE CREDENTIALS
    private const DB_HOST = "localhost";
    private const DB_NAME = "portfolio";
    private const DB_USER = "root";
    private const DB_PASSWORD = "";

    // GET CONNECTION TO DB
    public function getConnection(): PDO
    {
        $pdo = new PDO('mysql:host=' . $this::DB_HOST . ';charset=utf8mb4;dbname=' . $this::DB_NAME, $this::DB_USER, $this::DB_PASSWORD);
        return $pdo;
    }
}
