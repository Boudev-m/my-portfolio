<!-- PAGE UPDATE PASSWORD ACCOUNT (BACK OFFICE) -->

<?php

use App\Controllers\AccountController;

include '../../assets/components/back/head.php' ?>
<title>Modifier mon compte</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../src/Controllers/Authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'update') {
    // require_once '../../Controllers/AccountController.php';
    (new AccountController)->updatePassword();
} ?>

<?php include '../../assets/components/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Modifier mon mot de passe</h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <div class="row w-100 mx-auto my-2">
            <div class="col-7 mx-auto py-3">
                <form action='' method='post'>
                    <?php if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }; ?>
                    <table class='table table-striped table-hover te    xt-center border border-secondary'>
                        <input type='hidden' name='action' value='update'>
                        <tr>
                            <th class='text-end col-5'>Mot de passe actuel :</th>
                            <td class='text-break fw-bold'><input class='form-control' type='password' name='password' id='password'></td>
                        </tr>
                        <tr>
                            <th class='text-end col-5'>Nouveau mot de passe :</th>
                            <td class='text-break fw-bold'><input class='form-control' type='password' name='newPassword' id='newPassword'></td>
                        </tr>
                        <tr>
                            <th class='text-end col-5'>Confirmer le mot de passe :</th>
                            <td class='text-break fw-bold'><input class='form-control' type='password' name='newPasswordConfirmation' id='newPasswordConfirmation'></td>
                        </tr>
                    </table>
                    <div class='text-center'>
                        <button class='btn btn-success py-2 px-4 border border-dark' type='submit' name="submit">Valider</button>
                        <a href='./' class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include '../../assets/components/back/footer.php' ?>