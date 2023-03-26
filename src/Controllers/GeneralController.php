<?php
// GENERAL CONTROLLER
// Contains uncategorized and useful functions

namespace App\Controllers;

class GeneralController
{
    // REDIRECT WITH SUCCESS (redirects the user with a success message)
    public static function redirectWithSuccess(string $path, string $message): void
    {
        $_SESSION['message'] = "<p class='success-message fs-5 text-center'><img src='/assets/images/icons/success-icon.png' alt='success icon'> $message</p>";
        exit(header("Location: $path"));
    }

    // REDIRECT WITH ERROR
    public static function redirectWithError(string $path, string $error): void
    {
        $_SESSION['message'] = "<p class='error-message fs-5 text-center'><img src='/assets/images/icons/error-icon.png' alt='error icon'> $error</p>";
        exit(header("Location: $path"));
    }

    // COUNT ALL DATAS (counts total rows in a table)
    public static function countAllDatas(string $table): int
    {
        $table = trim($table);
        $sql = "SELECT * FROM $table";
        $statement = DatabaseConnection::getConnection()->prepare($sql);
        $statement->execute();
        return $statement->rowCount();
    }
}
