<!-- LOGIN PAGE (TO ACCESS THE BACK OFFICE) -->

<!-- HEAD -->
<?php include '../assets/components/front/head.php' ?>
<title>Connexion</title>

<?php

use App\Controllers\AccountController;

// CHECK IF USER LOGGED
if (isset($_SESSION['isLogged'], $_SESSION['role'])) {
    if ($_SESSION['isLogged'] && $_SESSION['role'] === 'admin') exit(header('Location: http://localhost/portfolio/admin/dashboard'));
};

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'login') (new AccountController)->login($_POST['email'], $_POST['password']) ?>

<!-- HEADER -->
<?php include '../assets/components/front/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-2">ESPACE DE CONNEXION</h4>
    </div>
    <div style="border: 2px solid #666;">
        <div class="col-4 mx-auto py-4">
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            };
            ?>
            <form class="form-group" action="" method="post">
                <input type="hidden" name="action" value="login">
                <label for="email">Adresse email :</label>
                <input type="email" class="form-control my-2 border border-dark" name="email" id="email">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control my-2 border border-dark" name="password" id="password">
                <button class="btn btn-success border border-dark w-100 my-4" type="submit" name="submit">CONNEXION</button>
            </form>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include '../assets/components/front/footer.php' ?>