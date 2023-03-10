<!-- SKILL LIST PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Gestion des Compétences</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\SkillController;

// CHECK AUTH
Authentication::check();

// GET ALL SKILLS FROM DB
$skills = (new SkillController())->readAll() ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <a href="http://localhost/portfolio/admin/skill/createSkill.php">
            <img src="../../assets/images/icons/add-button.svg" alt="ajouter un nouvel élément" title='Ajouter une réalisation' width=3% style='border-radius:50%;position:fixed; left:17vh;'>
        </a>
        <h4 class="text-center text-light py-2">Gestion des Compétences</h4>
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
                <th class="col-1">Image</th>
                <th class="col-2">Titre</th>
                <th class="col-2">Type</th>
                <th class="col-3">Description</th>
                <th class="col-2">Statut</th>
                <th class="text-center col-1">Voir</th>
                <th class="text-center col-1">Modifier</th>
                <th class="text-center col-1">Supprimer</th>
            </tr>

            <!-- AFFICHE TOUTES LES COMPETENCES -->
            <?php foreach ($skills as $skill) : ?>

                <tr class='align-middle'>

                    <td><?= $skill->id_skill ?></td>
                    <td>
                        <img src='../../assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' width=70% class='rounded'>
                    </td>
                    <td class='text-break'><?= $skill->title ?></td>
                    <td>
                        <span style="color:<?= $skill->getType()['color'] ?>;font-weight:bold;">
                            <?= $skill->getType()['type'] ?>
                        </span>
                    </td>
                    <td class='text-break'><?= $skill->description ?? '&#8211' ?></td>
                    <td><?= $skill->getStatut() ?></td>
                    <td class='text-center'>
                        <a href='./<?= $skill->id_skill ?>' title='Voir'>
                            <div class='btn btn-success fs-5 py-1 px-2 border border-dark'>&#128209;</div>
                        </a>
                    </td>
                    <td class='text-center'>
                        <a href='./<?= $skill->id_skill ?>/update' title='Modifier'>
                            <div class='btn btn-info fs-5 py-1 px-2 border border-dark'>&#128394;</div>
                        </a>
                    </td>
                    <td class='text-center'>
                        <a href='./<?= $skill->id_skill ?>/confirm-delete' title='Supprimer'>
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