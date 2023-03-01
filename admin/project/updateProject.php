<!-- PAGE PROJECT UPDATE (BACK OFFICE) -->

<?php

use App\Controllers\ProjectController; ?>

<?php include '../../assets/components/back/head.php' ?>
<title>Détail réalisation</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../src/Controllers/Authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'update') {

    (new ProjectController)->update($_POST['id']);
} ?>

<!-- GET ONE PROJECT FROM DB -->
<?php
// require '../../Controllers/ProjectController.php';
$project = (new ProjectController())->readOne($_GET['id']);
?>

<?php include '../../assets/components/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Modifier la réalisation n°<?= $project->id_project ?></h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <div class="col-6 mx-auto py-3">

            <form action='' method='post' enctype='multipart/form-data'>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                };
                ?>
                <table class="table table-striped table-hover">
                    <input type='hidden' name='action' value='update'>
                    <input type='hidden' name='id' value='<?= $project->id_project ?>'>
                    <tr>
                        <th class='text-end align-middle col-3'>Titre :</th>
                        <td><input class='form-control' type='text' name='title' id='title' value='<?= $project->title ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end'>Description :</th>
                        <td><textarea class='form-control' name='description' id='description' rows='2'><?= $project->description ?></textarea></td>
                    </tr>

                    <!-- DATE -->
                    <tr>
                        <th class='text-end'>Date début :</th>
                        <td><input class="form-control pointer border border-dark w-50" type="date" name="date-start" id="date-start" value='<?= $project->date_start ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end'>Date de fin :</th>
                        <td><input class="form-control pointer border border-dark w-50" type="date" name="date-end" id="date-end" value='<?= $project->date_end ?>'></td>
                    </tr>


                    <tr>
                        <th class='text-end align-middle col-3'>Image :</th>
                        <td><input class='form-control' type='file' name='image' id='image'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Lien :</th>
                        <td><input class='form-control' type='text' name='link' id='link' value='<?= $project->link ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Statut :</th>
                        <td>
                            <select class='pointer' style='padding: 10px;' name='isActive' id='isActive'>
                                <option value=1>Activé</option>
                                <option value=0 <?= $project->active ?: 'selected' ?>>Désactivé</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class='text-center'>
                    <button class='btn btn-success py-2 px-4 border border-dark' type='submit' name='submit'>Valider</button>
                    <a href='../<?= $project->id_project ?>' class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../../assets/components/back/footer.php' ?>