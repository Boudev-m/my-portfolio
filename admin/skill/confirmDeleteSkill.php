<!-- PAGE DE DEMANDE DE CONFIRMATION DE SUPPRESSION DE COMPETENCE (ACCES ADMIN UNIQUEMENT) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Confirmation de suppression</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'delete') {
    require_once '../../core/skillController.php';
    (new SkillController)->delete($_POST['id']);
} ?>

<!-- GET ONE SKILL FROM DB -->
<?php
require '../../core/skillController.php';
$skill = (new SkillController())->readOne($_GET['id']);
// $type = $skill->type === 1 ? '<span style="color:red;font-weight:bold;">Front-end</span>' : '<span style="color:blue;font-weight:bold;">Back-end</span>';
// $text = !empty($skill->description) ? $skill->description : '&#8211';
// $image = !empty($skill->image) ? $skill->image : 'no-image.png';
// $link = !empty($skill->link) ? "<a href='$skill->link' class='fw-bold' target='_blank'>$skill->link</a>" : '&#8211';
// $active = $skill->active ? 'Activé' : 'Désactivé';
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Suppression de la compétence n°<?= $skill->id_skill ?></h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <h5 class="text-center py-3">Voulez-vous vraiment supprimer cette compétence ?</h5>
        <h5 class="text-center text-danger fw-bold mx-auto p-0">Attention, cette action est irréversible.</h5>
        <div class="col-5 mx-auto py-3">
            <table class="table table-striped table-hover border border-secondary">

                <!-- AFFICHE LA COMPETENCE RECUPERéE DANS LA BDD -->
                <tr>
                    <td class='text-center' colspan='2'><img src='../../assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' width=20% class='rounded'></td>
                </tr>
                <tr>
                    <th class='text-end col-6'>Id :</th>
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
                    <a href="./detailSkill.php?id=<?= $skill->id_skill ?>" class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>