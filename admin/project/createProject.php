<!-- NEW PROJECT PAGE (BACK OFFICE) -->

<!-- HEAD -->
<?php include '../../assets/components/back/head.php' ?>
<title>Nouvelle réalisation</title>

<?php

use App\Controllers\Authentication;
use App\Controllers\ProjectController;

// CHECK AUTH
Authentication::check();

// CHECK IF FORM SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'create') (new ProjectController)->create() ?>

<!-- HEADER -->
<?php include '../../assets/components/back/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="mb-2">
        <h4 class="text-center text-light py-2">Ajouter une réalisation</h4>
    </div>
    <div class='content' style="border: 2px solid #666;">
        <div class="col-5 mx-auto py-3">
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            };
            ?>
            <form action="" method="post" enctype="multipart/form-data">

                <input type="hidden" name="action" value="create">

                <!-- TITLE -->
                <div>
                    <label for="title">Titre :</label>
                    <input class="form-control pointer border border-dark" type="text" name="title" id="title">
                </div>

                <!-- DESCRIPTION -->
                <div class="my-2">
                    <label for="text">Description :</label>
                    <textarea class="form-control pointer border border-dark" name="description" id="description" rows="3"></textarea>
                </div>

                <!-- DATE -->
                <div class="d-flex mx-auto justify-content-evenly mt-3 text-center">
                    <div>
                        <label for="date-start">
                            Date de début :
                        </label>
                        <input class="form-control pointer border border-dark" type="date" name="date-start" id="date-start">
                    </div>
                    <div>
                        <label for="date-end">
                            Date de fin :
                        </label>
                        <input class="form-control pointer border border-dark" type="date" name="date-end" id="date-end">
                    </div>
                </div>

                <!-- LINK -->
                <div class="my-2">
                    <label for="link">Lien :</label>
                    <input class="form-control pointer border border-dark" type="text" name="link" id="link">
                </div>

                <!-- IMAGE -->
                <div class="my-2 pointer">
                    <label for="image">Charger une image :</label>
                    <input class="form-control pointer border border-dark" type="file" name="image" id="image">
                </div>

                <!-- ACTIVE -->
                <div class="text-center my-3">
                    <label for="isActive">Activer la réalisation ?</label>
                    <select class='pointer' style='padding: 10px;' name='isActive' id='isActive'>
                        <option value=1>Activer</option>
                        <option value=0>Désactiver</option>
                    </select>
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit" name="submit" class="btn btn-success border border-dark w-100">ENREGISTRER</button>
            </form>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include '../../assets/components/back/footer.php' ?>