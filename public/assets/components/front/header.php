<body style="background: #EEE">
    <div>
        <div style="background-color: rgb(0, 0, 0, 0.1)">
            <header class="col col-sm-11 col-md-9 mx-auto py-1">
                <nav class="navbar navbar-expand-lg my-2 navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand d-block" id="logo" href="/" style='padding:0;'>
                            <img class='d-block' src="/assets/images/icons/bouimust-logo.png" alt="Logo du site" style="width:65px;opacity:0.7;transition-duration:300ms;transform:scale(1);" onmouseout="this.style.opacity=0.7;this.style.transform='scale(1)'" onmouseover="this.style.opacity=1;this.style.transform='scale(1.1)'">
                        </a>

                        <div class="d-flex d-lg-none mx-auto me-1">
                            <div class="mx-1">
                                <a href="https://github.com/Bouimust" class="d-block rounded-circle" style="transform:rotate(0deg);transition:500ms" onmouseout="this.style.transform='rotate(0deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(360deg)'+'scale(1.2)'">
                                    <img src="/assets/images/icons/github-icon.svg" class="rounded-circle" alt="mon github" title="Github" width="40px">
                                </a>
                            </div>
                            <div class="mx-1">
                                <a href="https://www.linkedin.com/in/mustapha-bouibrine-b83216265" class="d-block rounded-circle" style="transform:rotate(0deg);transition:500ms" onmouseout="this.style.transform='rotate(0deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(-360deg)'+'scale(1.2)'">
                                    <img src="/assets/images/icons/linkedin-icon.svg" class="rounded-circle" alt="mon linkedin" title="LinkedIn" width="40px">
                                </a>
                            </div>
                        </div>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="/">Accueil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="/contact">Contact</a>
                                </li>
                                <?php if (isset($_SESSION['isLogged'], $_SESSION['role'])) : ?>
                                    <?php if ($_SESSION['isLogged'] && $_SESSION['role'] === 'admin') : ?>
                                        <li class="nav-item">
                                            <a class="nav-link text-danger" href="/admin/dashboard">Tableau de bord</a>
                                        </li>
                                    <?php endif ?>
                                <?php endif ?>
                            </ul>
                            <div class="mx-1">
                                <a href="https://github.com/Bouimust" class="d-none d-lg-block rounded-circle" style="transform:rotate(0deg);transition:500ms" onmouseout="this.style.transform='rotate(0deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(360deg)'+'scale(1.2)'">
                                    <img src="/assets/images/icons/github-icon.svg" class="rounded-circle" alt="mon github" title="Github" width="40px">
                                </a>
                            </div>
                            <div class="mx-1">
                                <a href="https://www.linkedin.com/in/mustapha-bouibrine-b83216265" class="d-none d-lg-block rounded-circle" style="transform:rotate(0deg);transition:500ms" onmouseout="this.style.transform='rotate(0deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(-360deg)'+'scale(1.2)'">
                                    <img src="/assets/images/icons/linkedin-icon.svg" class="rounded-circle" alt="mon linkedin" title="LinkedIn" width="40px">
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
        </div>