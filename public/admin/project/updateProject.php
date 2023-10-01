<!-- UPDATE PROJECT PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Modification de réalisation</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\ProjectController;
use App\Controllers\SkillController;

// CHECK AUTH
Authentication::check();

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'update') (new ProjectController)->update($_POST['id']);

// GET PROJECT AND ALL SKILLS FROM DB
$project = (new ProjectController())->readOne($_GET['id']);
$project->skills = (new ProjectController)->loadSkillsFromProject($project);
$skills = (new SkillController)->readAll() ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Modifier la réalisation n°<?= $project->id_project ?></h4>
    </div>
    <div class="content" style="border: 2px solid #666;">
        <div class="col-6 mx-auto py-3">

            <form action='' method='post' enctype='multipart/form-data'>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                };
                ?>
                <table class="table table-striped table-hover">
                    <input type='hidden' name='action' value='update'>
                    <input type='hidden' name='id' value='<?= $project->id_project ?>'>
                    <tr>
                        <th class='text-end align-middle col-3'>Titre :</th>
                        <td><input class='form-control' type='text' name='title' id='title' value='<?= $project->title ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end'>Description :</th>
                        <td><textarea class='form-control' name='description' id='description' rows='2'><?= $project->description ?></textarea></td>
                    </tr>

                    <tr>
                        <th class="text-end">Compétence(s) exploitée(s) :</th>
                        <td>
                            <?php foreach ($skills as $skill) : ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pointer border border-dark" type="checkbox" name="skills[]" id="skill-<?= $skill->id_skill ?>" value="<?= $skill->id_skill ?>" <?php foreach ($project->skills as $skillOfProject) : ?> <?= $skill->id_skill === $skillOfProject->id_skill ? 'checked' : '' ?> <?php endforeach ?>>
                                    <label class="form-check-label pointer" for="skill-<?= $skill->id_skill ?>">
                                        <img src='/assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' title="<?= $skill->title ?>" width=40px class='rounded'>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </td>
                    </tr>

                    <!-- DATE -->
                    <tr>
                        <th class='text-end'>Date début :</th>
                        <td><input class="form-control pointer border border-dark w-50" type="date" name="date-start" id="date-start" value='<?= $project->date_start ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end'>Date de fin :</th>
                        <td><input class="form-control pointer border border-dark w-50" type="date" name="date-end" id="date-end" value='<?= $project->date_end ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Image :</th>
                        <td><input class='form-control' type='file' name='image' id='image'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Lien web :</th>
                        <td><input class='form-control' type='text' name='link-web' id='link-web' value='<?= $project->link_web ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Lien github :</th>
                        <td><input class='form-control' type='text' name='link-github' id='link-github' value='<?= $project->link_github ?>'></td>
                    </tr>
                    <tr>
                        <th class='text-end align-middle col-3'>Statut :</th>
                        <td>
                            <select class='pointer' style='padding: 10px;' name='isActive' id='isActive'>
                                <option value=1>Activé</option>
                                <option value=0 <?= $project->active ?: 'selected' ?>>Désactivé</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class='text-center'>
                    <button class='btn btn-success py-2 px-4 border border-dark' type='submit' name='submit'>Valider</button>
                    <a href='../<?= $project->id_project ?>' class='btn btn-danger py-2 px-4 border border-dark'>Retour</a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>