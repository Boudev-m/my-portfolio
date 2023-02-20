<!-- PAGE DE CONNEXION ADMIN -->

<?php include '../assets/inc/front/head.php' ?>
<title>Connexion</title>

<!-- Vérifie si l'admin est dejà connecté -->
<?php
if (isset($_SESSION['isLog'], $_SESSION['role'])) {
    if ($_SESSION['isLog'] && $_SESSION['role'] === 'admin') {
        exit(header('Location: http://localhost/portfolio/admin/dashboard.php'));
    }
}
?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'login') {
    require_once '../core/accountController.php';
    (new AccountController)->login($_POST['email'], $_POST['password']);
} ?>

<?php include '../assets/inc/front/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-2">CONNEXION</h4>
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

<?php include '../assets/inc/front/footer.php' ?>