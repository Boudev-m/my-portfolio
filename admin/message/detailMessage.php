<!-- MESSAGE DETAIL (ADMIN UNIQUEMENT) -->
<!-- Page qui affiche les détails sur un message depuis l'id en parametre url-->

<?php include '../../assets/inc/back/head.php' ?>
<title>Détail message</title>

<!-- Vérifie si l'message connecté est Admin -->
<?php require '../../core/authentificationAdmin.php' ?>

<!-- GET ONE MESSAGE FROM DB -->
<?php
require '../../core/messageController.php';
$message = getOneMessage($_GET['id']);
$company = !empty($message['company']) ? $message['company'] : '&#8211';
$phone = !empty($message['phone']) ? $message['phone'] : '&#8211';
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Détails sur le message n°<?= $message['id'] ?></h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="pb-0" style="border: 2px solid #666;">
        <div class="row w-100 mx-auto my-2">

            <div class="d-flex">

                <table class='h-25 w-75 table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-3'>Id :</th>
                        <td><?= $message['id'] ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Prénom :</th>
                        <td class='text-break'><?= $message['first_name'] ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Nom :</th>
                        <td><?= $message['last_name'] ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Email :</th>
                        <td class='text-break'><?= $message['email'] ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Société :</th>
                        <td class='text-break fw-bold'><?= $company ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Téléphone :</th>
                        <td class='text-break fw-bold'><?= $phone ?></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td class='text-center'>
                            <a href='./updateMessage.php?id=<?= $message['id'] ?>' title='Modifier le message'>
                                <div class='btn btn-info fs-5 py-1 px-3 border border-dark'>&#128394;</div>
                            </a>
                            <a href='./confirmDeleteMessage.php?id=<?= $message['id'] ?>' title='Supprimer le message'>
                                <div class='btn btn-danger fs-5 py-1 px-3 border border-dark'>&#128465;</div>
                            </a>
                        </td>
                    </tr>

                </table>

                <table class='table table-striped table-hover text-center border border-secondary'>
                    <tr>
                        <th class='text-center'>Message :</th>
                    </tr>
                    <tr>
                        <td class='text-break fw-bold' style='text-align:justify'><?= nl2br($message['text']) ?></td>
                    </tr>
                </table>

            </div>
        </div>
        <a href="./" class="btn btn-success border border-dark w-100">Retour à la liste des messages</a>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>