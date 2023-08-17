<!-- HOME PAGE (FRONT OFFICE) -->

<!-- HEAD -->
<?php require_once join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'head.php']) ?>
<title>Portfolio de BouiMust</title>

<?php

use App\Controllers\ProjectController;
use App\Controllers\SkillController;
use App\Controllers\MessageController;

// CHECK IF FORM IS SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'newMessage') (new MessageController)->create();

// GET DATAS FROM DB
$projects = (new ProjectController)->readAll('active', 'ORDER BY id_project DESC');
foreach ($projects as $project) {
    $project->skills = (new ProjectController)->loadSkillsFromProject($project);
}
// var_dump($projects);
// exit;
$skills = (new SkillController())->readAll('active');
$messages = array_reverse((new MessageController())->readAll('visible'));
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
                <div class='w-75 py-5 text-center text-warning mx-auto'>Aucune réalisation n'a été publiée ...</div>
            <?php else : ?>
                <div class="w-75 row row-cols-1 mx-auto row-cols-md-3 py-5 justify-content-between">
                    <?php foreach ($projects as $project) : ?>
                        <div class="card-project col mx-auto my-1" style="width:250px;">
                            <a href="<?= $project->link ?? '#' ?>" class="text-decoration-none d-block h-100 w-100 pt-2 rounded">

                                <!-- CARD -->
                                <div class="card bg-transparent h-100 border border-secondary" style="transition:300ms" onmouseout="this.style.transform='translate(0,0)'" onmouseover="this.style.transform='translate(0,-10px)'">
                                    <div class="container-project-picture">
                                        <img src="./assets/images/upload/<?= $project->getImage() ?>" class="card-img-top project-picture border-bottom border-secondary" alt="image de <?= $project->title ?>">
                                    </div>
                                    <div class="card-body text-dark pb-1">
                                        <h5 class="card-title"><?= $project->title ?></h5>
                                        <p class="card-text" style="font-size: 0.9em;"><?= $project->description ?></p>
                                    </div>
                                    <div class="text-end opacity-75 border-top border-secondary p-1">
                                        <?php foreach ($project->skills as $skill) : ?>
                                            <img src='/assets/images/upload/<?= $skill->getImage() ?>' alt='image de <?= $skill->title ?>' title="<?= $skill->title ?>" width=30px class='rounded'>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                                <!-- END -->

                            </a>
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
                <div class='w-75 py-5 text-center text-warning mx-auto'>Aucune compétence n'a été publiée ...</div>
            <?php else : ?>
                <div class="w-75 row row-cols-1 mx-auto row-cols-md-3 py-5 justify-content-between">
                    <?php foreach ($skills as $skill) : ?>
                        <div class="col-sm-4 mx-auto" style="max-width:150px;max-height:150px;">
                            <div class="card border-warning border-top-0 border-bottom-0 border-start border-end shadow h-100 bg-transparent" style="transform:rotate(5deg);transition:300ms" onmouseout="this.style.transform='rotate(5deg)'+'scale(1)'" onmouseover="this.style.transform='rotate(0deg)'+'scale(1.1)'" title="<?= $skill->title ?>">
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


    <!-- FORM MESSAGE BLOCK-->
    <div id="messageForm" class="container w-100 w-sm-75 my-5 bg-transparent">
        <div class="mb-4">
            <h1 class="text-center text-sm-start pt-1">Laisser un commentaire</h1>
        </div>
        <div>
            <div class="col col-sm-10 col-md-8 col-lg-6">
                <form action="" method="post">

                    <div class="row">
                    </div>

                    <input type="hidden" name="action" value="newMessage">
                    <input type="hidden" name="path" value=<?= $_SERVER['SCRIPT_NAME'] . '#messageForm' ?>>
                    <input type="hidden" name="isVisible" id="isVisible" value=1>
                    <input type="hidden" name="first-name" id="first-name">
                    <input type="hidden" name="company" id="company">
                    <input type="hidden" name="phone" id="phone">

                    <div class="col col-sm-9 col-md-6">
                        <div class="mb-2">
                            <input class="form-control pointer border border-dark" type="text" name="last-name" id="last-name" placeholder="Nom *">
                        </div>
                        <div class="mb-2">
                            <input class="form-control pointer border border-dark" type="text" name="email" id="email" placeholder="Adresse email *">
                        </div>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control pointer border border-dark" name="content" id="content" rows="3" placeholder="Votre message *"></textarea>
                    </div>


                    <div class="mx-auto mx-sm-0 my-3 w-50">
                        <button type="submit" name="submit" class="btn btn-success border border-dark w-100">ENVOYER</button>
                    </div>
                    <p class="text-center text-sm-start py-0 my-0">* : champ obligatoire</p>
                    <div>
                        <?php
                        if (isset($_SESSION['message']) && isset($_SESSION['messageSection'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message'], $_SESSION['messageSection']);
                        };
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- MESSAGE LIST BLOCK -->
    <div class="container w-100 w-sm-75 my-5 bg-transparent w-50">

        <?php if (!$messages) : ?>
            <div class='py-3 px-2 mb-3' style="background-color: rgb(0, 0, 0, 0.1)">Aucun commentaire n'a été publié ...</div>
        <?php else : ?>
            <?php define('PROFIL_COLORS', ['#0099cc', '#9933ff', '#cc0000', '#ff9933', '#009933', '#777']) ?>
            <?php foreach ($messages as $message) : ?>
                <?php $randomColor = PROFIL_COLORS[mt_rand(0, count(PROFIL_COLORS) - 1)] ?>
                <div class='p-2 mb-3' style="background-color: rgb(0, 0, 0, 0.1)">
                    <div class="border-bottom border-secondary d-flex pb-1">
                        <div class="pe-3" style="width: max-content;">
                            <img src="./assets/images/icons/default-profile.svg" alt="photo par defaut" style="width:50px;border-radius:50%;background:<?= $randomColor ?>;">
                        </div>
                        <div>
                            <p class="m-0"><?= $message->first_name ?> <?= $message->last_name ?>,</p>
                            <p class="m-0">le <?= $message->getDate() ?> à <?= $message->getTime() ?></p>
                        </div>
                    </div>
                    <p class='text-break'><?= $message->getContent() ?></p>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</main>

<!-- FOOTER -->
<?php include join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'components', 'front', 'footer.php']) ?>