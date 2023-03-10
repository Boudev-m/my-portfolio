<!-- MESSAGE DETAILS PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Détails du message</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\MessageController;

// CHECK AUTH
Authentication::check();

// GET MESSAGE FROM DB 
$message = (new MessageController())->readOne($_GET['id']) ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Détails sur le message n°<?= $message->id_message ?></h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        };
        ?>
        <div class="row w-100 mx-auto my-2">

            <div class="d-flex">

                <table class='h-25 w-75 table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-3'>N° :</th>
                        <td><?= $message->id_message ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Nom :</th>
                        <td><?= $message->last_name ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Prénom :</th>
                        <td class='text-break'><?= $message->first_name ?? '&#8211' ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Email :</th>
                        <td class='text-break'><?= $message->email ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Société :</th>
                        <td class='text-break'><?= $message->company ?? '&#8211' ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Téléphone :</th>
                        <td class='text-break'><?= $message->phone ?? '&#8211' ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Visibilité :</th>
                        <td class='text-break'><?= $message->getVisibility() ?? '&#8211' ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Date d'envoi :</th>
                        <td class='text-break'><?= $message->getDate() ?> à <?= $message->getTime() ?></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td class='text-center'>
                            <a href='./<?= $message->id_message ?>/update' title='Modifier le message'>
                                <div class='btn btn-info fs-5 py-1 px-3 border border-dark'>&#128394;</div>
                            </a>
                            <a href='./<?= $message->id_message ?>/confirm-delete' title='Supprimer le message'>
                                <div class='btn btn-danger fs-5 py-1 px-3 border border-dark'>&#128465;</div>
                            </a>
                        </td>
                    </tr>

                </table>

                <table class='table table-striped table-hover text-center border border-secondary'>
                    <tr>
                        <th class='text-center'>Contenu du message :</th>
                    </tr>
                    <tr>
                        <td class='text-break fw-bold h-100' style='text-align:justify'><?= $message->getContent() ?></td>
                    </tr>
                </table>

            </div>
        </div>
        <a href="./" class="btn btn-success border border-dark w-100">Retour à la liste des messages</a>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>