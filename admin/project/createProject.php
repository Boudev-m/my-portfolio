<!-- PAGE NOUVELLE PROJET (BACK-OFFICE) -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Nouvelle Réalisation</title>

<!-- Vérifie si l'user est admin en analysant les données en session -->
<?php require '../../core/authentification.php' ?>

<!-- Vérifie que le formulaire est soumis -->
<?php if (isset($_POST['submit']) && $_POST['action'] === 'create') {
    require_once '../../core/projectController.php';
    (new ProjectController)->create();
} ?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Ajouter une réalisation</h4>
    </div>
    <div style="border: 2px solid #666;">
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

                <!-- TEXT -->
                <div class="my-2">
                    <label for="text">Description :</label>
                    <textarea class="form-control pointer border border-dark" name="text" id="text" rows="é"></textarea>
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

<?php include '../../assets/inc/back/footer.php' ?>