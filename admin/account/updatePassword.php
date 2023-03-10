<!-- UPDATE ACCOUNT PASSWORD PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Modifier mon compte</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\AccountController;

// CHECK AUTH
Authentication::check();

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'update') (new AccountController)->updatePassword() ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Modifier mon mot de passe</h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
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

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>