<!-- Vérifie si l'utilisateur connecté est admin, en analysant les données en session -->
<?php
if (!($_SESSION['isLog'] && $_SESSION['role'] === 'admin')) {
    require_once 'generalController.php';
    GeneralController::redirectWithError('http://localhost/portfolio/', 'Accès refusé.');
}
?>