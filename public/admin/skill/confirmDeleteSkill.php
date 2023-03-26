<!-- CONFIRM DELETE SKILL PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Confirmation de suppression</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\SkillController;

// CHECK AUTH
Authentication::check();

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'delete') (new SkillController)->delete($_POST['id']);

// GET SKILL FROM DB
$skill = (new SkillController())->readOne($_GET['id']) ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Suppression de la compétence n°<?= $skill->id_skill ?></h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <h5 class="text-center py-3">Voulez-vous vraiment supprimer cette compétence ?</h5>
        <h5 class="text-center text-danger fw-bold mx-auto p-0">Attention, cette action est irréversible.</h5>
        <div class="col-5 mx-auto py-3">
            <table class="table table-striped table-hover border border-secondary">

                <!-- AFFICHE LA COMPETENCE RECUPERéE DANS LA BDD -->
                <tr>
                    <td class='text-center' colspan='2'><img src='../../../assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' width=20% class='rounded'></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>N° :</th>
                    <td class='col-6'><?= $skill->id_skill ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Titre :</th>
                    <td class='col-6 text-break'><?= $skill->title ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Type :</th>
                    <td class='col-6'><span style="color:<?= $skill->getType()['color'] ?>;font-weight:bold;"><?= $skill->getType()['type'] ?></span></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Description :</th>
                    <td class='col-6 text-break'><?= $skill->description ?? '&#8211' ?></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Lien :</th>
                    <td class='col-6 text-break'>
                        <?php if ($skill->link) : ?>
                            <a href='<?= $skill->link ?>' class='fw-bold' target='_blank'><?= $skill->link ?></a>
                        <?php else : ?>
                            &#8211
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Statut :</th>
                    <td class='col-6'><?= $skill->getStatut() ?></td>
                </tr>
            </table>
            <form action="" method="post">
                <input type='hidden' name='action' value='delete'>
                <input type='hidden' name='id' value='<?= $skill->id_skill ?>'>
                <div class="py-1 text-center">
                    <button type='submit' name='submit' class='btn btn-success py-2 px-4 border border-dark'>Valider</button>
                    <a href="../<?= $skill->id_skill ?>" class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>