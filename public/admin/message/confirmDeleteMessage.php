<!-- CONFIRM DELETE MESSAGE PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Confirmation de suppression</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\MessageController;

// CHECK AUTH
Authentication::check();

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'delete') (new MessageController)->delete($_POST['id']);

// GET MESSAGE FROM DB
$message = (new MessageController())->readOne($_GET['id']);
?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Suppression du message n°<?= $message->id_message ?></h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <h5 class="text-center py-3">Voulez-vous vraiment supprimer ce message ?</h5>
        <h5 class="text-center text-danger fw-bold p-0">Attention, cette action est irréversible.</h5>
        <div class="col-6 mx-auto py-3">
            <table class='table table-striped table-hover text-center border border-secondary'>
                <tr>
                    <th class='text-center'>Contenu du message :</th>
                </tr>
                <tr>
                    <td class='text-break fw-bold text-justify' style='text-align:justify'><?= $message->getContent() ?></td>
                </tr>
            </table>
            <table class="table table-striped table-hover border border-secondary">

                <!-- AFFICHE LE MESSAGE RECUPERé DANS LA BDD -->
                <tr>
                    <th class='text-end col-6'>N° :</th>
                    <td class='col-6'><?= $message->id_message ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Nom :</th>
                    <td class='col-6'><?= $message->last_name ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Prénom :</th>
                    <td class='col-6'><?= $message->first_name ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Email :</th>
                    <td class='col-6'><?= $message->email ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Société :</th>
                    <td class='col-6'><?= $message->company ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Téléphone :</th>
                    <td class='col-6'><?= $message->phone ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Visibilité :</th>
                    <td class='col-6'><?= $message->getVisibility() ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Date d'envoi :</th>
                    <td class='col-6'><?= $message->getDate() ?> à <?= $message->getTime() ?></td>
                </tr>
            </table>
            <form action="" method="post">
                <input type='hidden' name='action' value='delete'>
                <input type='hidden' name='id' value='<?= $message->id_message ?>'>
                <div class="py-3 text-center">
                    <button type='submit' name='submit' class='btn btn-success py-2 px-4 border border-dark'>Valider</button>
                    <a href="../<?= $message->id_message ?>" class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>