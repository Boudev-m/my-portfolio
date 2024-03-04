<!-- HOME PAGE (FRONT OFFICE) -->

<!-- HEAD -->
<?php require_once join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'head.php']) ?>
<title>Portfolio de Bouibrine Mustapha - Bouimust</title>

<?php

use App\Controllers\ProjectController;
use App\Controllers\SkillController;
// use App\Controllers\MessageController;

// CHECK IF FORM IS SUBMITTED
// if (isset($_POST['submit']) && $_POST['action'] === 'newMessage') {
//     sleep(1);
//     (new MessageController)->create();
// }
// GET DATAS FROM DB
$projects = (new ProjectController)->readAll('active', 'ORDER BY id_project DESC');
foreach ($projects as $project) {
    $project->skills = (new ProjectController)->loadSkillsFromProject($project);
}
$skills = (new SkillController())->readAll('active');
?>

<!-- HEADER -->
<?php require_once join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'header.php']) ?>

<!-- MAIN CONTENT -->
<main>
    <?php
    if (isset($_SESSION['message']) && !isset($_SESSION['messageSection'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="my-2">

        <!-- PROJECT LIST BLOCK -->
        <div>
            <h1 class="text-center mt-4"><img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> MES RÉALISATIONS <img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>
        <div style="background-color: rgb(0, 0, 0, 0.1)">
            <?php if (!$projects) : ?>
                <div class='py-5 text-center text-warning mx-auto'>Aucune réalisation n'a été publiée ...</div>
            <?php else : ?>
                <div class="row row-cols-1 mx-auto row-cols-md-3 py-5 justify-content-between" style="max-width:1100px;width:90%">
                    <?php foreach ($projects as $project) : ?>
                        <div class="card-project col mx-auto my-1" style="width:250px;">

                            <!-- CARD -->
                            <div class="card bg-transparent h-100 border border-secondary">
                                <div class="container-project-picture">
                                    <img src="./assets/images/upload/<?= $project->getImage() ?>" class="card-img-top project-picture border-bottom border-secondary" alt="image de <?= $project->title ?>">
                                </div>
                                <div class="card-body text-dark pb-1">
                                    <h5 class="card-title"><?= $project->title ?></h5>
                                    <p class="card-text" style="font-size: 0.9em;"><?= $project->description ?></p>
                                </div>
                                <div class="text-end opacity-75 border-top border-secondary p-1">
                                    <?php foreach ($project->skills as $skill) : ?>
                                        <img src='/assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' title="<?= $skill->title ?>" width=25px class='rounded'>
                                    <?php endforeach ?>
                                </div>
                                <?php if ($project->link_web) : ?>
                                    <p class="lien lien1">
                                        <a href="<?= $project->link_web ?? '#' ?>" style="word-break: keep-all;">Voir en ligne
                                            <img src="./assets/images/icons/web_icon.svg" alt="github" width="25px" style="filter: invert(1);">
                                        </a>
                                    </p>
                                <?php endif ?>
                                <?php if ($project->link_github) : ?>
                                    <p class="lien lien2">
                                        <a href="<?= $project->link_github ?? '#' ?>">Voir sur github
                                            <img src="./assets/images/icons/github-mark-white.svg" alt="github" width="25px">
                                        </a>
                                    </p>
                                <?php endif ?>
                            </div>
                            <!-- END CARD -->

                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>

        <!-- SKILL LIST BLOCK -->
        <div>
            <h1 class="text-center mt-5"><img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> MES COMPÉTENCES <img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>
        <div style="background-color: rgb(0, 0, 0, 0.1)">
            <?php if (!$skills) : ?>
                <div class='py-5 text-center text-warning mx-auto'>Aucune compétence n'a été publiée ...</div>
            <?php else : ?>
                <div class="row row-cols-1 mx-auto row-cols-md-3 py-5 justify-content-between" style="max-width:1100px;width:90%">
                    <?php foreach ($skills as $skill) : ?>
                        <div class="col-sm-4 mx-auto mb-3" style="max-width:140px;max-height:140px;">
                            <div class="card card-skill border-warning border-top-0 border-bottom-0 border-start border-end shadow h-100 bg-transparent" style="transform:rotate(5deg);transition:300ms" onmouseout="this.style.transform='rotate(5deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(0deg)'+'scale(1.1)'" title="<?= $skill->title ?>">
                                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                                    <div class="icon-box icon-box--success">
                                        <img src="./assets/images/upload/<?= $skill->getImage() ?>" alt="logo de <?= $skill->title ?>" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>

        <!-- PARCOURS BLOCK -->
        <div>
            <h1 class="text-center mt-5"><img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> MON PARCOURS DEVELOPPEUR <img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>
        <div class="py-4 text-center" style="background-color: rgb(0, 0, 0, 0.1)">
            <h6 class="py-3"><span class='text-primary'>2023</span> : POEC Developpeur PHP - Symfony</h6>
            <h6 class="py-3"><span class='text-primary'>2022</span> : Titre RNCP Niveau 5 Developpeur Web</h6>
        </div>

    </div>

</main>

<!-- FOOTER -->
<?php include join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'footer.php']) ?>