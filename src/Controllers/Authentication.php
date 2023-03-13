<?php
// AUTHENTICATION CONTROLLER

namespace App\Controllers;

class Authentication
{
    // CHECK IF USER IS AUTHENTICATED
    public static function check(): void
    {
        if (!(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] === 'admin')) {
            GeneralController::redirectWithError('/', 'Accès refusé.');
        }
    }
}
