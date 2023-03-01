<!-- SKILL DETAIL (ACCES ADMIN UNIQUEMENT) -->
<!-- Page qui affiche les détails sur une compétence (depuis l'id en parametre url)-->

<?php

use App\Controllers\SkillController;

include '../../assets/components/back/head.php' ?>
<title>Détail compétence</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../src/Controllers/Authentification.php' ?>

<!-- GET ONE SKILL FROM DB -->
<?php
// require '../../Controllers/SkillController.php';

$skill = (new SkillController())->readOne($_GET['id']);
?>

<?php include '../../assets/components/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Détails sur la compétence n°<?= $skill->id_skill ?></h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="pb-0" style="border: 2px solid #666;">

        <div class="row w-100 mx-auto my-2">

            <div class='col-4 ps-4 d-flex justify-content-center align-items-center'><img class='rounded' src='../../assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' width=80%></div>
            <div class="col-8">
                <table class='table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-3'>N° :</th>
                        <td><?= $skill->id_skill ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Titre :</th>
                        <td class='text-break'><?= $skill->title ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Type :</th>
                        <td><span style="color:<?= $skill->getType()['color'] ?>;font-weight:bold;"><?= $skill->getType()['type'] ?></span></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Description :</th>
                        <td class='text-break'><?= $skill->description ?? '&#8211' ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Lien :</th>
                        <td class='text-break'>
                            <?php if ($skill->link) : ?>
                                <a href='<?= $skill->link ?>' class='fw-bold' target='_blank'><?= $skill->link ?></a>
                            <?php else : ?>
                                &#8211
                            <?php endif ?>
                        </td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Statut :</th>
                        <td><?= $skill->getStatut() ?></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td class='text-center'>
                            <a href='./<?= $skill->id_skill ?>/update' class="text-decoration-none" title='Modifier'>
                                <div class='btn btn-info fs-5 py-1 px-3 border border-dark'>&#128394;</div>
                            </a>
                            <a href='./<?= $skill->id_skill ?>/delete-confirmation' class="text-decoration-none" title='Supprimer'>
                                <div class='btn btn-danger fs-5 py-1 px-3 border border-dark'>&#128465;</div>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="./" class="btn btn-success border border-dark w-100">Retour à la liste des compétences</a>
    </div>
</main>

<?php include '../../assets/components/back/footer.php' ?>