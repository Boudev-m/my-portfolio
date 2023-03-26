<!-- ACCOUNT DETAILS PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Détails du compte</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\AccountController;

// CHECK AUTH
Authentication::check();

// GET ACCOUNT FROM DB
$myAccount = (new AccountController)->read() ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Détails de mon compte</h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <div class="row w-100 mx-auto my-2">
            <div class="col-6 mx-auto py-3">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                };
                ?>
                <table class='table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-4'>N° identifiant :</th>
                        <td><?= $myAccount->id_account ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-4'>Email :</th>
                        <td class='text-break'><?= $myAccount->email ?>
                            <a href='./update-email' title="Modifier l'email">
                                <div class='btn btn-info fs-6 py-1 px-2 border border-dark'>&#128394;</div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th class='text-end col-4'>Mot de passe :</th>
                        <td class='text-break'><?= $myAccount->hidden_password ?>
                            <a href='./update-password' title="Modifier le mot de passe">
                                <div class='btn btn-info fs-6 py-1 px-2 border border-dark'>&#128394;</div>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th class='text-end col-4'>Date de la dernière modification :</th>
                        <td class='text-break'>le <?= $myAccount->getDate() ?> à <?= $myAccount->getTime() ?></td>
                    </tr>

                </table>
            </div>
        </div>
        <a href="../dashboard" class="btn btn-success border border-dark w-100">Retour au Tableau de bord</a>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>