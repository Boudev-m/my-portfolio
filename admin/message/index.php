<!-- MESSAGE LIST PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Gestion des Messages</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\MessageController;

// CHECK AUTH
Authentication::check();

// GET ALL MESSAGES FROM DB
$messages = (new MessageController())->readAll();
?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Gestion des Messages</h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        };
        ?>
        <table class="table table-striped table-hover">

            <!-- EN-TETES DU TABLEAU -->
            <tr class="text-center">
                <th class="col-1">N°</th>
                <th class="col-2">Nom</th>
                <th class="col-2">Prénom</th>
                <th class="col-2">Email</th>
                <th class="col-2">Société</th>
                <th class="col-2">Téléphone</th>
                <th class="col-2">Visibilité</th>
                <th class="text-center col-1">Voir</th>
                <th class="text-center col-1">Modifier</th>
                <th class="text-center col-1">Supprimer</th>
            </tr>

            <!-- AFFICHE TOUS LES MESSAGES -->
            <?php foreach ($messages as $message) : ?>
                <tr class='align-middle text-center'>
                    <td><?= $message->id_message ?></td>
                    <td><?= $message->last_name ?></td>
                    <td><?= $message->first_name ?? '&#8211' ?></td>
                    <td><?= $message->email ?></td>
                    <td><?= $message->company ?? '&#8211' ?></td>
                    <td><?= $message->phone ?? '&#8211' ?></td>
                    <td><?= $message->getVisibility() ?></td>
                    <td class='text-center'><a href='./<?= $message->id_message ?>' title='Voir le message'>
                            <div class='btn btn-success fs-5 py-1 px-2'>&#128209;</div>
                        </a></td>
                    <td class='text-center'><a href='./<?= $message->id_message ?>/update' title='Modifier le message'>
                            <div class='btn btn-info fs-5 py-1 px-2'>&#128394;</div>
                        </a></td>
                    <td class='text-center'><a href='./<?= $message->id_message ?>/confirm-delete' title='Supprimer le message'>
                            <div class='btn btn-danger fs-5 py-1 px-2'>&#128465;</div>
                        </a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>