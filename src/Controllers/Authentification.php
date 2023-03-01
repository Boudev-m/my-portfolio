<?php
// Vérifie si l'utilisateur connecté est admin, en analysant les données en session

namespace App\Controllers;

if (!(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] && $_SESSION['role'] === 'admin')) {
    // require_once 'GeneralController.php';
    GeneralController::redirectWithError('http://localhost/portfolio/', 'Accès refusé.');
}
