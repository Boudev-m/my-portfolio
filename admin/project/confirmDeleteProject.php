<!-- PAGE DE DEMANDE DE CONFIRMATION DE SUPPRESSION DE REALISATION (ACCES ADMIN UNIQUEMENT) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Confirmation de suppression</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'delete') {
    require_once '../../core/projectController.php';
    (new ProjectController)->delete($_POST['id']);
} ?>

<!-- GET ONE PROJECT FROM DB -->
<?php
require '../../core/projectController.php';
$project = (new ProjectController())->readOne($_GET['id']);
$text = !empty($project->text) ? $project->text : '&#8211';
$image = !empty($project->image) ? $project->image : 'no-image.png';
$date_start = implode('/', array_reverse(explode('-', $project->date_start)));
$date_end = !is_null($project->date_end) ? implode('/', array_reverse(explode('-', $project->date_end))) : '&#8211';
$link = !empty($project->link) ? "<a href='{$project->link}' class='fw-bold' target='_blank'>{$project->link}</a>" : '&#8211';
$active = $project->active === '1' ? 'Activé' : 'Désactivé';
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Suppression de la réalisation n°<?= $project->id_project ?></h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <h5 class="text-center py-3">Voulez-vous vraiment supprimer cette réalisation ?</h5>
        <h5 class="text-center text-danger fw-bold mx-auto p-0">Attention, cette action est irréversible.</h5>
        <div class="col-5 mx-auto py-3">
            <table class="table table-striped table-hover border border-secondary">

                <!-- AFFICHE LA REALISATION RECUPERéE DANS LA BDD -->
                <tr>
                    <td class='text-center' colspan='2'><img src='../../assets/images/upload/<?= $image ?>' alt='image de la réalisation' width=20% class='rounded'></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Id :</th>
                    <td class='col-6'><?= $project->id_project ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Titre :</th>
                    <td class='col-6 text-break'><?= $project->title ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Description :</th>
                    <td class='col-6 text-break'><?= $text ?></td>
                </tr>
                <tr>
                    <th class='text-end col-3'>Date de début :</th>
                    <td class='text-break'><?= $date_start ?></td>
                </tr>
                <tr>
                    <th class='text-end col-3'>Date de fin :</th>
                    <td class='text-break'><?= $date_end ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Lien :</th>
                    <td class='col-6 text-break'><?= $link ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Statut :</th>
                    <td class='col-6'><?= $active ?></td>
                </tr>
            </table>
            <form action="" method="post">
                <input type='hidden' name='action' value='delete'>
                <input type='hidden' name='id' value='<?= $project->id_project ?>'>
                <div class="py-1 text-center">
                    <button type='submit' name='submit' class='btn btn-success py-2 px-4 border border-dark'>Valider</button>
                    <a href="./detailProject.php?id=<?= $project->id_project ?>" class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>