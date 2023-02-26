<!-- PAGE DETAIL PROJECT (BACK-OFFICE) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Détail réalisation</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- GET ONE PROJECT FROM DB -->
<?php
require '../../core/projectController.php';
$project = (new ProjectController)->readOne($_GET['id']);
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Détails sur la réalisation n°<?= $project->id_project ?></h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">

        <div class="row w-100 mx-auto my-2">

            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            };
            ?>
            <div class='col-4 ps-4 my-auto text-center'>
                <a href="http://localhost/portfolio/assets/images/upload/<?= $project->getImage() ?>">
                    <img class='rounded' src='http://localhost/portfolio/assets/images/upload/<?= $project->getImage() ?>' alt='image de la réalisation' width=99%>
                </a>
            </div>
            <div class="col-8">
                <table class='table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-3'>N° :</th>
                        <td><?= $project->id_project ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Titre :</th>
                        <td class='text-break'><?= $project->title ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Description :</th>
                        <td class='text-break'><?= $project->description ?? '&#8211' ?></td>
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
                        <th class='text-end col-3'>Lien :</th>
                        <td class='text-break'>
                            <?php if ($project->link) : ?>
                                <a href='<?= $project->link ?>' class='fw-bold' target='_blank'><?= $project->link ?></a>
                            <?php else : ?>
                                &#8211
                            <?php endif ?>
                        </td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Statut :</th>
                        <td><?= $project->getStatut() ?></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td class='text-center'>
                            <a href='./<?= $project->id_project ?>/update' class="text-decoration-none" title='Modifier'>
                                <div class='btn btn-info fs-5 py-1 px-3 border border-dark'>&#128394;</div>
                            </a>
                            <a href='./<?= $project->id_project ?>/delete-confirmation' class="text-decoration-none" title='Supprimer'>
                                <div class='btn btn-danger fs-5 py-1 px-3 border border-dark'>&#128465;</div>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="./" class="btn btn-success border border-dark w-100">Retour à la liste des réalisations</a>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>