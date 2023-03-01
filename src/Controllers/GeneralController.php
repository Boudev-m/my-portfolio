<?php

namespace App\Controllers;

// use App\Controllers\DatabaseConnection;

if (session_status() === 1) session_start();
// require_once(__DIR__ . "/DatabaseConnection.php");

class GeneralController
{
    // FONCTION REDIRECTION AVEC SUCCES (redirige l'utilisateur avec un message de succès)
    public static function redirectWithSuccess(string $path, string $message): void
    {
        $_SESSION['message'] = "<p class='alert alert-success fs-5 text-center p-1'>$message</p>";
        exit(header("Location: $path"));
    }

    // FONCTION REDIRECTION AVEC ERREUR (redirige l'utilisateur avec un message d'erreur)
    public static function redirectWithError(string $path, string $error): void
    {
        $_SESSION['message'] = "<p class='alert alert-danger fs-5 text-center p-1'>$error</p>";
        exit(header("Location: $path"));
    }

    // FUNCTION COUNT ALL DATAS (compte le nombre total de lignes d'une table)
    public static function countAllDatas(string $table): int
    {
        $table = trim($table);
        $sql = "
            SELECT * FROM $table
        ";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        return $statement->rowCount();
    }
}
