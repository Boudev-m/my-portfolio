<!-- SKILL UPDATE (ADMIN UNIQUEMENT) -->
<!-- Page qui permet de modifier les infos d'une compétence -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Détail compétence</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentificationAdmin.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit'])) {
    require_once '../../core/skillController.php';
    (new SkillController)->update($_POST['id']);
} ?>

<!-- GET ONE SKILL FROM DB -->
<?php
require '../../core/skillController.php';
$skill = (new SkillController())->getOne($_GET['id']);
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Modifier la compétence n°<?= $skill->id_skill ?></h4>
    </div>
    <div class="pb-0" style="border: 2px solid #666;">
        <div class="col-6 mx-auto py-3">

            <form action='' method='post' enctype='multipart/form-data'>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                };
                ?>
                <table class="table table-striped">

                    <input type='hidden' name='action' value='update'>
                    <input type='hidden' name='id' value='<?= $skill->id_skill ?>'>
                    <tr class='align-middle vertical-align-center'>
                        <th class='text-end align-middle col-3'>Id :</th>
                        <td><?= $skill->id_skill ?></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Titre :</th>
                        <td><input class='form-control' type='text' name='title' id='title' value='<?= $skill->title ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Type :</th>
                        <td>
                            <div class='d-flex mx-auto justify-content-evenly mt-3'>
                                <div class='form-check form-switch'>
                                    <label class='form-check-label' for='front-end'>Front-end</label>
                                    <input class='form-check-input' type='radio' name='type' id='front-end' value='1' <?= $skill->type === 1 ? 'checked' : ''; ?>>
                                </div>
                                <div class='form-check form-switch'>
                                    <label class='form-check-label' for='back-end'>Back-end</label>
                                    <input class='form-check-input' type='radio' name='type' id='back-end' value='2' <?= $skill->type === 2 ? 'checked' : ''; ?>>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class='text-end'>Description :</th>
                        <td><textarea class='form-control' name='text' id='text' rows='5'><?= $skill->text ?></textarea></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Image :</th>
                        <td><input class='form-control' type='file' name='image' id='image'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Lien :</th>
                        <td><input class='form-control' type='text' name='link' id='link' value='<?= $skill->link ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Statut :</th>
                        <td>
                            <select class='pointer' style='padding: 10px;' name='isActive' id='isActive'>
                                <option value=1>Activé</option>
                                <option value=0 <?= !$skill->active ? 'selected' : '' ?>>Désactivé</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class='text-center'>
                    <button class='btn btn-success py-2 px-4 border border-dark' type='submit' name="submit">Valider</button>
                    <a href='./detailSkill.php?id=<?= $skill->id_skill ?>' class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>