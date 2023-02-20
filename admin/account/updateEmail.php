<!-- PAGE UPDATE EMAIL ACCOUNT (BACK OFFICE) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Modifier mon compte</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'update') {
    require_once '../../core/accountController.php';
    (new AccountController)->updateEmail();
} ?>

<!-- GET ACCOUNT FROM DB -->
<?php
require '../../core/accountController.php';
$myAccount = (new AccountController)->read();
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Modifier mon adresse email</h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <div class="row w-100 mx-auto my-2">
            <div class="col-7 mx-auto py-3">
                <form action='' method='post'>
                    <?php if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }; ?>
                    <table class='table table-striped table-hover text-center border border-secondary'>

                        <input type='hidden' name='action' value='update'>
                        <tr>
                            <th class='text-end col-5'>Email actuel :</th>
                            <td class='text-break'><input class='form-control' type='text' name='email' id='email' value='<?= $myAccount->email ?>'></td>
                        </tr>

                        <tr>
                            <th class='text-end col-5'>Nouvel email :</th>
                            <td class='text-break'><input class='form-control' type='text' name='newEmail' id='newEmail'></td>
                        </tr>

                        <tr>
                            <th class='text-end col-5'>Confirmer nouvel email :</th>
                            <td class='text-break'><input class='form-control' type='text' name='newEmailConfirmation' id='newEmailConfirmation'></td>
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

<?php include '../../assets/inc/back/footer.php' ?>