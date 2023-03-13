<?php
// DATABASECONNECTION CONTROLLER
// Config controller to connect to 'Portfolio' MySQL database, using PDO (PHP Data Objects)
// Using environment variables for credentials

namespace App\Controllers;

use PDO;
use Dotenv\Dotenv;


class DatabaseConnection
{
    // DATABASE CREDENTIALS
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASSWORD;
    public Dotenv $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
        $this->dotenv->load();
        $this->DB_HOST = $_ENV['DB_HOST'];
        $this->DB_NAME = $_ENV['DB_NAME'];
        $this->DB_USER = $_ENV['DB_USER'];
        $this->DB_PASSWORD = $_ENV['DB_PASSWORD'];
    }

    // GET CONNECTION TO DB
    public function getConnection(): PDO
    {
        $pdo = new PDO("mysql:host=$this->DB_HOST;charset=utf8mb4;dbname=$this->DB_NAME", $this->DB_USER, $this->DB_PASSWORD);
        return $pdo;
    }
}
