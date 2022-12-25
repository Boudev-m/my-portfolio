<body>
    <div class="container">

        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark my-2" style="border: 2px solid #666;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="http://localhost/portfolio/admin/dashboardAdmin.php">ADMINISTRATION</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="http://localhost/portfolio/admin/dashboardAdmin.php">TABLEAU DE BORD</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    GESTION
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/user/manageUsers.php">Utilisateurs</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/skill/manageSkills.php">Compétences</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/message/manageMessages.php">Messages</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/project/manageProjects.php">Réalisations</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    CREATION
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/user/createUser.php">Utilisateur</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/skill/createSkill.php">Compétence</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/message/createMessage.php">Message</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/portfolio/admin/project/createProject.php">Réalisation</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form action="../core/userController.php" method="post">
                            <input type="hidden" name="action" value="logout">
                            <button class="btn btn-danger" type="submit">DECONNEXION</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>