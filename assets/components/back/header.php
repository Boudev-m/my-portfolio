<?php

use App\Controllers\AccountController;

// CHECK IF LOGOUT FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'logout') (new AccountController)->logout();
?>

<body class="bg-dark">
    <div class="container">
        <header>
            <nav class="navbar navbar-expand-lg my-2" style="border: 2px solid #666;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="http://localhost/portfolio/admin/dashboard">&#128451; TABLEAU DE BORD</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    GESTION
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/project">Réalisations</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/skill">Compétences</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/message">Messages</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/account">Mon compte</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    AJOUTER
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/project/new">Réalisation</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/skill/new">Compétence</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="http://localhost/portfolio">&#127962; RETOUR ACCUEIL</a>
                            </li>
                        </ul>
                        <form action="" method="post">
                            <input type="hidden" name="action" value="logout">
                            <button class="btn btn-secondary" type="submit" name="submit">DECONNEXION</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>