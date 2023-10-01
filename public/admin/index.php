<!-- LOGIN PAGE (TO ACCESS THE BACK OFFICE) -->

<!-- HEAD -->
<?php require_once join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'head.php']) ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript" defer>
    function enableSubmitButton() {
        const submitButton = document.getElementById("submit-button");
        submitButton.removeAttribute("disabled");
    }
</script>
<title>Connexion</title>

<?php

use App\Controllers\AccountController;

// CHECK IF USER LOGGED
if (isset($_SESSION['isLogged'], $_SESSION['role'])) {
    if ($_SESSION['isLogged'] && $_SESSION['role'] === 'admin') exit(header('Location: /admin/dashboard'));
};

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'login') {
    sleep(1);
    (new AccountController)->login($_POST['email'], $_POST['password']);
}
?>

<!-- HEADER -->
<?php require_once join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'header.php']) ?>

<!-- MAIN CONTENT -->
<main>
    <div class="my-2">
        <div>
            <h1 class="text-center mt-4"><img src="/assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> ESPACE DE CONNEXION <img src="/assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>
        <div class='py-4' style="background-color: rgb(0, 0, 0, 0.1)">
            <div class="col-9 col-sm-7 col-md-5 col-lg-4 col-xl-3 mx-auto">
                <p class="card-text text-center text-primary">Veuillez vous identifier.</p>
                <form class="form-group form-login" action="" method="post">
                    <input type="hidden" name="action" value="login">
                    <label for="email">Adresse email :</label>
                    <input type="text" class="form-control my-2 border border-dark rounded-0" name="email" id="email">
                    <label for="password">Mot de passe :</label>
                    <input type="password" class="form-control my-2 border border-dark rounded-0" name="password" id="password">
                    <div class="g-recaptcha d-flex justify-content-center" data-sitekey="6LfI5VQoAAAAABE-Jc-j0BItn0nl_tv49RmIVEeB" data-callback="enableSubmitButton"></div>
                    <button id="submit-button" class="d-block btn btn-success border border-dark w-50 my-4 mx-auto rounded-0" type="submit" name="submit" disabled>SE CONNECTER</button>
                </form>
            </div>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            };
            ?>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php require_once join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'footer.php']) ?>