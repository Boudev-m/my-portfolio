<?php define('BACKGROUND_COLOR', ['#410016', '#3c003f', '#120046', '#003346', '#003016', '#383000', '#333']) ?>
<?php define('RANDOM_BACKGROUND', BACKGROUND_COLOR[mt_rand(0, count(BACKGROUND_COLOR) - 1)]) ?>

<body style="background:<?= RANDOM_BACKGROUND ?>;">
    <div class="container">

        <header>
            <nav class="navbar navbar-expand-lg my-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="http://localhost/portfolio">&#127962; ACCUEIL</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost/portfolio/contact">CONTACT</a>
                            </li>
                            <?php if (isset($_SESSION['isLogged'], $_SESSION['role'])) : ?>
                                <?php if ($_SESSION['isLogged'] && $_SESSION['role'] === 'admin') : ?>
                                    <li class="nav-item">
                                        <a class="nav-link text-danger" href="http://localhost/portfolio/admin/dashboard">TABLEAU DE BORD</a>
                                    </li>
                                <?php endif ?>
                            <?php endif ?>
                        </ul>
                        <div class="mx-1">
                            <a href="https://github.com/Bouimust" class="d-block rounded-circle">
                                <img src="http://localhost/portfolio/assets/images/icons/github-icon.svg" class="rounded-circle" alt="mon github" title="Github" width="40px">
                            </a>
                        </div>
                        <div class="mx-1">
                            <a href="https://www.linkedin.com/in/mustapha-bouibrine-b83216265" class="d-block rounded-circle">
                                <img src="http://localhost/portfolio/assets/images/icons/linkedin-icon.svg" class="rounded-circle" alt="mon linkedin" title="LinkedIn" width="40px">
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>