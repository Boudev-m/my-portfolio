<!-- PAGE PROJECT UPDATE (BACK OFFICE) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Détail réalisation</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'update') {
    require_once '../../core/projectController.php';
    (new ProjectController)->update($_POST['id']);
} ?>

<!-- GET ONE PROJECT FROM DB -->
<?php
require '../../core/ProjectController.php';
$project = (new ProjectController())->readOne($_GET['id']);
?>

<?php include '../../assets/inc/back/header.php' ?>

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

                    <!-- AFFICHE LA COMPETENCE A MODIFIER -->
                    <!-- Je place l'action (=update) et l'id de la réalisation dans un input caché -->
                    <!-- il me serviront pour modifier la réalisation (dans projectController.php) -->

                    <input type='hidden' name='action' value='update'>
                    <input type='hidden' name='id' value='<?= $project->id_project ?>'>
                    <tr class='align-middle vertical-align-center'>
                        <th class='text-end align-middle col-3'>Id :</th>
                        <td><?= $project->id_project ?></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Titre :</th>
                        <td><input class='form-control' type='text' name='title' id='title' value='<?= $project->title ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end'>Description :</th>
                        <td><textarea class='form-control' name='text' id='text' rows='3'><?= $project->text ?></textarea></td>
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
                    <a href='./detailProject.php?id=<?= $project->id_project ?>' class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>