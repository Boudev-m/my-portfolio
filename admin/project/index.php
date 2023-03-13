<!-- PROJECT LIST PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Gestion des Réalisations</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\ProjectController;

// CHECK AUTH
Authentication::check();

// GET ALL PROJECTS FROM DB
$projects = (new ProjectController())->readAll() ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <a href="/admin/project/createProject.php">
            <img src="/assets/images/icons/add-button.svg" alt="ajouter un nouvel élément" title='Ajouter une réalisation' width=3% style='border-radius:50%;position:fixed; left:17vh;'>
        </a>
        <h4 class="text-center text-light py-2">Gestion des Réalisations</h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        };
        ?>
        <table class="table table-striped table-hover text-center">

            <!-- EN-TETES DU TABLEAU -->
            <tr>
                <th class="col-1">N°</th>
                <th class="col-3">Image</th>
                <th class="col-3">Titre</th>
                <th class="col-4">Description</th>
                <th class="col-2">Début</th>
                <th class="col-1">Fin</th>
                <th class="col-2">Statut</th>
                <th class="text-center col-1">Voir</th>
                <th class="text-center col-1">Modifier</th>
                <th class="text-center col-1">Supprimer</th>
            </tr>

            <!-- AFFICHE TOUTES LES COMPETENCES -->
            <?php foreach ($projects as $project) : ?>
                <tr class='align-middle'>
                    <td><?= $project->id_project ?></td>
                    <td><img src='../../assets/images/upload/<?= $project->getImage() ?>' alt='image de <?= $project->title ?>' width=50% class='rounded'></td>
                    <td class='text-break'><?= $project->title ?></td>
                    <td class='text-break'><?= $project->description ?? '&#8211' ?></td>
                    <td><?= $project->getDateStart() ?></td>
                    <td><?= $project->getDateEnd() ?? '&#8211' ?></td>
                    <td><?= $project->getStatut() ?></td>
                    <td class='text-center'><a href='./<?= $project->id_project ?>' title='Voir'>
                            <div class='btn btn-success fs-5 py-1 px-2 border border-dark'>&#128209;</div>
                        </a></td>
                    <td class='text-center'><a href='./<?= $project->id_project ?>/update' title='Modifier'>
                            <div class='btn btn-info fs-5 py-1 px-2 border border-dark'>&#128394;</div>
                        </a></td>
                    <td class='text-center'><a href='./<?= $project->id_project ?>/confirm-delete' title='Supprimer'>
                            <div class='btn btn-danger fs-5 py-1 px-2 border border-dark'>&#128465;</div>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>