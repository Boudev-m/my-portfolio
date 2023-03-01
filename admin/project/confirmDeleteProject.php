<!-- PAGE DE DEMANDE DE CONFIRMATION DE SUPPRESSION DE REALISATION (ACCES ADMIN UNIQUEMENT) -->

<?php

use App\Controllers\ProjectController;

include '../../assets/components/back/head.php' ?>
<title>Confirmation de suppression</title>

<!-- Vérifie l'authentification -->
<?php require '../../src/Controllers/Authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'delete') (new ProjectController)->delete($_POST['id']); ?>

<!-- GET ONE PROJECT FROM DB -->
<?php $project = (new ProjectController())->readOne($_GET['id']); ?>

<?php include '../../assets/components/back/header.php' ?>

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
                    <td class='text-center' colspan='2'><img src='../../../assets/images/upload/<?= $project->getImage() ?>' alt='image de <?= $project->title ?>' width=20% class='rounded'></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>N° :</th>
                    <td class='col-6'><?= $project->id_project ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Titre :</th>
                    <td class='col-6 text-break'><?= $project->title ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Description :</th>
                    <td class='col-6 text-break'><?= $project->description ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-3'>Date de début :</th>
                    <td class='text-break'><?= $project->getDateStart() ?></td>
                </tr>
                <tr>
                    <th class='text-end col-3'>Date de fin :</th>
                    <td class='text-break'><?= $project->getDateEnd() ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Lien :</th>
                    <td class='col-6 text-break'>
                        <?php if ($project->link) : ?>
                            <a href='<?= $project->link ?>' class='fw-bold' target='_blank'><?= $project->link ?></a>
                        <?php else : ?>
                            &#8211
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Statut :</th>
                    <td class='col-6'><?= $project->getStatut() ?></td>
                </tr>
            </table>
            <form action="" method="post">
                <input type='hidden' name='action' value='delete'>
                <input type='hidden' name='id' value='<?= $project->id_project ?>'>
                <div class="py-1 text-center">
                    <button type='submit' name='submit' class='btn btn-success py-2 px-4 border border-dark'>Valider</button>
                    <a href="../<?= $project->id_project ?>" class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../../assets/components/back/footer.php' ?>