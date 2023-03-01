<!-- PAGE MESSAGE UPDATE (BACK OFFICE) -->

<?php

use App\Controllers\MessageController;

include '../../assets/components/back/head.php' ?>
<title>Modification Message</title>

<!-- Vérifie si le message connecté est Admin -->
<?php require '../../src/Controllers/Authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'update') {
    // require_once '../../Controllers/MessageController.php';
    (new MessageController)->update($_POST['id']);
} ?>

<!-- GET ONE SKILL FROM DB -->
<?php
// require '../../Controllers/MessageController.php';
$message = (new MessageController())->readOne($_GET['id']);
?>

<?php include '../../assets/components/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Modifier le message n°<?= $message->id_message ?></h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="py-2" style="border: 2px solid #666;">

        <form action="" method="post">

            <div class="row col-8 justify-content-center mx-auto">

                <input type='hidden' name='action' value='update'>
                <input type='hidden' name='id' value='<?= $message->id_message ?>'>
                <input type="hidden" name="path" value=<?= $_SERVER['SCRIPT_NAME'] . '?id=' . $message->id_message ?>>

                <div class="col-6">
                    <div class="my-1">
                        <label for="last-name">Nom * :</label>
                        <input class="form-control pointer border border-dark" type="text" name="last-name" id="last-name" value="<?= $message->last_name ?>">
                    </div>
                    <div class="my-1">
                        <label for="first-name">Prénom * :</label>
                        <input class="form-control pointer border border-dark" type="text" name="first-name" id="first-name" value="<?= $message->first_name ?>">
                    </div>
                    <div class="my-1">
                        <label for="email">Adresse email * :</label>
                        <input class="form-control pointer border border-dark" type="email" name="email" id="email" value="<?= $message->email ?>">
                    </div>
                </div>

                <div class="col-6">
                    <div class="my-1">
                        <label for="company">Société :</label>
                        <input class="form-control pointer border border-dark" type="text" name="company" id="company" value="<?= $message->company ?>">
                    </div>
                    <div class="my-1">
                        <label for="phone">Téléphone :</label>
                        <input class="form-control pointer border border-dark" type="tel" name="phone" id="phone" value="<?= $message->phone ?>">
                    </div>
                </div>


                <div class="my-1">
                    <label for="content">Message * :</label>
                    <textarea class="form-control pointer border border-dark" name="content" id="content" rows="6"><?= $message->content ?></textarea>
                </div>

                <div class="my-3">
                    <button type="submit" name="submit" class="btn btn-success border border-dark">ENREGISTRER</button>
                    <a href='../<?= $message->id_message ?>' class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
                <p>* : champ obligatoire</p>
            </div>
        </form>
    </div>
</main>

<?php include '../../assets/components/back/footer.php' ?>