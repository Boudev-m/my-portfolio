<?php
// GENERAL CONTROLLER
// Contains uncategorized and useful functions

namespace App\Controllers;

class GeneralController
{
    // REDIRECT WITH SUCCESS (redirects the user with a success message)
    public static function redirectWithSuccess(string $path, string $message): void
    {
        $_SESSION['message'] = "<p class='alert alert-success fs-5 text-center p-1'>$message</p>";
        exit(header("Location: $path"));
    }

    // REDIRECT WITH ERROR
    public static function redirectWithError(string $path, string $error): void
    {
        $_SESSION['message'] = "<p class='alert alert-danger fs-5 text-center p-1'>$error</p>";
        exit(header("Location: $path"));
    }

    // COUNT ALL DATAS (counts total rows in a table)
    public static function countAllDatas(string $table): int
    {
        $table = trim($table);
        $sql = "SELECT * FROM $table";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        return $statement->rowCount();
    }
}
