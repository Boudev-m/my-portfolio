<!-- INDEX MESSAGE (ACCES ADMIN UNIQUEMENT) -->
<!-- Page qui affiche tous les messages -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Gestion des Messages</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- GET ALL MESSAGES FROM DB -->
<?php
require '../../core/messageController.php';
$messages = (new MessageController())->readAll();
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <a href="http://localhost/portfolio/admin/message/createMessage.php">
            <img src="../../assets/images/icons/add-button.svg" alt="ajouter un nouvel élément" title='Ajouter une réalisation' width=3% style='border-radius:50%;position:fixed; left:17vh;'>
        </a>
        <h4 class="text-center pt-1">Gestion des Messages</h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="pb-0" style="border: 2px solid #666;">

        <table class="table table-striped table-hover">

            <!-- EN-TETES DU TABLEAU -->
            <tr class="text-center">
                <th class="col-1">Id</th>
                <th class="col-2">Prénom</th>
                <th class="col-2">Nom</th>
                <th class="col-2">Email</th>
                <th class="col-2">Société</th>
                <th class="col-2">Téléphone</th>
                <th class="text-center col-1">Voir</th>
                <th class="text-center col-1">Modifier</th>
                <th class="text-center col-1">Supprimer</th>
            </tr>

            <!-- AFFICHE TOUS LES MESSAGES -->
            <?php foreach ($messages as $message) :
                $company = !empty($message->company) ? $message->company : '&#8211';
                $phone = !empty($message->phone) ? $message->phone : '&#8211'; ?>
                <tr class='align-middle text-center'>
                    <td><?= $message->id_message ?></td>
                    <td><?= $message->first_name ?></td>
                    <td><?= $message->last_name ?></td>
                    <td><?= $message->email ?></td>
                    <td><?= $company ?></td>
                    <td><?= $phone ?></td>
                    <td class='text-center'><a href='./detailMessage.php?id=<?= $message->id_message ?>' title='Voir le message'>
                            <div class='btn btn-success fs-5 py-1 px-2'>&#128209;</div>
                        </a></td>
                    <td class='text-center'><a href='./updateMessage.php?id=<?= $message->id_message ?>' title='Modifier le message'>
                            <div class='btn btn-info fs-5 py-1 px-2'>&#128394;</div>
                        </a></td>
                    <td class='text-center'><a href='./confirmDeleteMessage.php?id=<?= $message->id_message ?>' title='Supprimer le message'>
                            <div class='btn btn-danger fs-5 py-1 px-2'>&#128465;</div>
                        </a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>