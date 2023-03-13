<!-- LOGIN PAGE (TO ACCESS THE BACK OFFICE) -->

<!-- HEAD -->
<?php include '../assets/components/front/head.php' ?>
<title>Connexion</title>

<?php

use App\Controllers\AccountController;

// CHECK IF USER LOGGED
if (isset($_SESSION['isLogged'], $_SESSION['role'])) {
    if ($_SESSION['isLogged'] && $_SESSION['role'] === 'admin') exit(header('Location: http://bouimust.com/admin/dashboard'));
};

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'login') (new AccountController)->login($_POST['email'], $_POST['password']) ?>

<!-- HEADER -->
<?php include '../assets/components/front/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="my-2 text-light">
        <div>
            <h1 class="text-center"><img src="../assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> ESPACE DE CONNEXION <img src="../assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>
        <div style="background-color: rgb(0, 0, 0, 0.3)">
            <div class="col-3 mx-auto py-4">
                <p class="card-text text-center text-warning">Veuillez vous identifier.</p>
                <form class="form-group" action="" method="post">
                    <input type="hidden" name="action" value="login">
                    <label for="email">Adresse email :</label>
                    <input type="email" class="form-control my-2 border border-dark" name="email" id="email">
                    <label for="password">Mot de passe :</label>
                    <input type="password" class="form-control my-2 border border-dark" name="password" id="password">
                    <button class="d-block btn btn-success border border-dark w-50 my-4 mx-auto" type="submit" name="submit">CONNEXION</button>
                </form>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                };
                ?>
            </div>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include '../assets/components/front/footer.php' ?>