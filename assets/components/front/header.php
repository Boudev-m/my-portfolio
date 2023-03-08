<?php define('BACKGROUND_COLOR', ['#410016', '#3c003f', '#120046', '#003346', '#003016', '#383000', '#333']) ?>
<?php define('RANDOM_BACKGROUND', BACKGROUND_COLOR[mt_rand(0, count(BACKGROUND_COLOR) - 1)]) ?>

<body style="background:<?= RANDOM_BACKGROUND ?>;">
    <div>
        <header class="w-75 mx-auto">
            <nav class="navbar navbar-expand-lg my-2 navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand d-block" id="logo" href="http://localhost/portfolio" style='padding:0;'>
                        <img class='d-block' src="http://localhost/portfolio/assets/images/icons/bouimust-logo.png" alt="Logo du site" style="width:65px;opacity:0.7;transition-duration:300ms;transform:scale(1);" onmouseout="this.style.opacity=0.7;this.style.transform='scale(1)'" onmouseover="this.style.opacity=1;this.style.transform='scale(1.1)'">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="http://localhost/portfolio">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="http://localhost/portfolio/contact">Contact</a>
                            </li>
                            <?php if (isset($_SESSION['isLogged'], $_SESSION['role'])) : ?>
                                <?php if ($_SESSION['isLogged'] && $_SESSION['role'] === 'admin') : ?>
                                    <li class="nav-item">
                                        <a class="nav-link text-danger" href="http://localhost/portfolio/admin/dashboard">Tableau de bord</a>
                                    </li>
                                <?php endif ?>
                            <?php endif ?>
                        </ul>
                        <div class="mx-1">
                            <a href="https://github.com/Bouimust" class="d-block rounded-circle" style="transform:rotate(0deg);transition:500ms" onmouseout="this.style.transform='rotate(0deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(360deg)'+'scale(1.2)'">
                                <img src="http://localhost/portfolio/assets/images/icons/github-icon.svg" class="rounded-circle" alt="mon github" title="Github" width="40px">
                            </a>
                        </div>
                        <div class="mx-1">
                            <a href="https://www.linkedin.com/in/mustapha-bouibrine-b83216265" class="d-block rounded-circle" style="transform:rotate(0deg);transition:500ms" onmouseout="this.style.transform='rotate(0deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(-360deg)'+'scale(1.2)'">
                                <img src="http://localhost/portfolio/assets/images/icons/linkedin-icon.svg" class="rounded-circle" alt="mon linkedin" title="LinkedIn" width="40px">
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>