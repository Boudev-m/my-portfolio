<!-- PAGE DETAIL ACCOUNT (BACK OFFICE) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Détails du compte</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- GET ACCOUNT FROM DB -->
<?php
require '../../core/accountController.php';
$myAccount = (new AccountController)->read();
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Détails de mon compte</h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="pb-0" style="border: 2px solid #666;">
        <div class="row w-100 mx-auto my-2">
            <div class="col-6 mx-auto py-3">
                <table class='table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-4'>Id :</th>
                        <td><?= $myAccount->id_account ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-4'>Email :</th>
                        <td class='text-break'><?= $myAccount->email ?>
                            <a href='./updateEmail.php' title="Modifier l'email">
                                <div class='btn btn-info fs-6 py-1 px-2 border border-dark'>&#128394;</div>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th class='text-end col-4'>Mot de passe :</th>
                        <td class='text-break'><?= $myAccount->hidden_password ?>
                            <a href='./updatePassword.php' title="Modifier le mot de passe">
                                <div class='btn btn-info fs-6 py-1 px-2 border border-dark'>&#128394;</div>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th class='text-end col-4'>Date de la dernière modification :</th>
                        <td class='text-break'>le xx/XX/XX</td>
                    </tr>

                </table>
            </div>
        </div>
        <a href="../dashboard.php" class="btn btn-success border border-dark w-100">Retour au Tableau de bord</a>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>