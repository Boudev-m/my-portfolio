<!-- INDEX PROJECTS (ADMIN UNIQUEMENT) -->
<!-- Page qui affiche tous les projets réalisés -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Gestion des Réalisations</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentificationAdmin.php' ?>

<!-- GET ALL PROJECTS FROM DB -->
<?php
require '../../core/projectController.php';
$projects = (new ProjectController())->getAll();
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <a href="http://localhost/portfolio/admin/project/createProject.php">
            <img src="../../assets/images/icons/add-button.svg" alt="ajouter un nouvel élément" title='Ajouter une réalisation' width=3% style='border-radius:50%;position:fixed; left:17vh;'>
        </a>
        <h4 class="text-center pt-1">Gestion des Réalisations</h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        };
        ?>
        <table class="table table-striped table-hover text-center">

            <!-- EN-TETES DU TABLEAU -->
            <tr>
                <th class="col-1">Id</th>
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
            <?php
            foreach ($projects as $project) :
                $image = !empty($project->image) ? $project->image : 'no-image.png';
                $text = !empty($project->text) ? $project->text : '&#8211';
                $date_start = implode('/', array_reverse(explode('-', $project->date_start)));
                $date_end = !is_null($project->date_end) ? implode('/', array_reverse(explode('-', $project->date_end))) : '&#8211';
                $active = $project->active ? 'Activé' : 'Désactivé';
                echo "
                    <tr class='align-middle'>
                    <td>{$project->id_project}</td>
                    <td><img src='../../assets/images/upload/$image' alt='image de la competence' width=50% class='rounded'></td>
                    <td class='text-break'>{$project->title}</td>
                    <td class='text-break'>$text</td>
                    <td>$date_start</td>
                    <td>$date_end</td>
                    <td>$active</td>
                    <td class='text-center'><a href='./detailProject.php?id={$project->id_project}' title='Voir'>
                    <div class='btn btn-success fs-5 py-1 px-2 border border-dark'>&#128209;</div></a></td>
                    <td class='text-center'><a href='./updateProject.php?id={$project->id_project}' title='Modifier'>
                    <div class='btn btn-info fs-5 py-1 px-2 border border-dark'>&#128394;</div></a></td>
                    <td class='text-center'><a href='./confirmDeleteProject.php?id={$project->id_project}' title='Supprimer'>
                    <div class='btn btn-danger fs-5 py-1 px-2 border border-dark'>&#128465;</div></a></td>
                    </tr>";
            endforeach;
            ?>
        </table>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>