<!-- CONFIRM DELETE PROJECT PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Confirmation de suppression</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\ProjectController;

// CHECK AUTH
Authentication::check();

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'delete') (new ProjectController)->delete($_POST['id']);

// GET PROJECT AND ASSOCIATED SKILLS FROM DB
$project = (new ProjectController)->readOne($_GET['id']);
$skills =  (new ProjectController)->loadSkillsFromProject($project) ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Suppression de la réalisation n°<?= $project->id_project ?></h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
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
                    <th class='text-end col-6'>Compétence(s) exploitée(s) :</th>
                    <td class='col-6 text-break'>
                        <?php foreach ($skills as $skill) : ?>
                            <img src='/assets/images/upload/<?= $skill->image ?>' alt='image de <?= $skill->title ?>' title="<?= $skill->title ?>" width=40px class='rounded'>
                        <?php endforeach ?>
                    </td>
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
                    <th class='text-end col-6'>Lien web :</th>
                    <td class='col-6 text-break'>
                        <?php if ($project->link_web) : ?>
                            <a href='<?= $project->link_web ?>' class='fw-bold' target='_blank'><?= $project->link_web ?></a>
                        <?php else : ?>
                            &#8211
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Lien github :</th>
                    <td class='col-6 text-break'>
                        <?php if ($project->link_github) : ?>
                            <a href='<?= $project->link_github ?>' class='fw-bold' target='_blank'><?= $project->link_github ?></a>
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

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>