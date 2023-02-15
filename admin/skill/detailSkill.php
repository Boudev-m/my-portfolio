<!-- SKILL DETAIL (ACCES ADMIN UNIQUEMENT) -->
<!-- Page qui affiche les détails sur une compétence (depuis l'id en parametre url)-->

<?php include '../../assets/inc/back/head.php' ?>
<title>Détail compétence</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentificationAdmin.php' ?>

<!-- GET ONE SKILL FROM DB -->
<?php
require '../../core/skillController.php';
$skill = (new SkillController())->getOne($_GET['id']);
$type = $skill->type === 1 ? '<span style="color:red;font-weight:bold;">Front-end</span>' : '<span style="color:blue;font-weight:bold;">Back-end</span>';
$text = !empty($skill->text) ? $skill->text : '&#8211';
$image = !empty($skill->image) ? $skill->image : 'no-image.png';
$link = !empty($skill->link) ? "<a href='{$skill->link}' class='fw-bold' target='_blank'>{$skill->link}</a>" : '&#8211';
$active = $skill->active ? 'Activé' : 'Désactivé';
?>

<?php include '../../assets/inc/back/header.php' ?>

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

            <div class='col-4 ps-4 d-flex justify-content-center align-items-center'><img class='rounded' src='../../assets/images/upload/<?= $image ?>' alt='image de la compétence' width=80%></div>
            <div class="col-8">
                <table class='table table-striped table-hover text-center border border-secondary'>

                    <tr class='align-middle'>
                        <th class='text-end col-3'>Id :</th>
                        <td><?= $skill->id_skill ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Titre :</th>
                        <td class='text-break'><?= $skill->title ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Type :</th>
                        <td><?= $type ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Description :</th>
                        <td class='text-break'><?= $text ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Lien :</th>
                        <td class='text-break'><?= $link ?></td>
                    </tr>

                    <tr>
                        <th class='text-end col-3'>Statut :</th>
                        <td><?= $active ?></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td class='text-center'>
                            <a href='./updateSkill.php?id=<?= $skill->id_skill ?>' class="text-decoration-none" title='Modifier'>
                                <div class='btn btn-info fs-5 py-1 px-3 border border-dark'>&#128394;</div>
                            </a>
                            <a href='./confirmDeleteSkill.php?id=<?= $skill->id_skill ?>' class="text-decoration-none" title='Supprimer'>
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

<?php include '../../assets/inc/back/footer.php' ?>