<!-- CONTACT PAGE (FRONT OFFICE) -->

<!-- HEAD -->
<?php include './assets/components/front/head.php' ?>
<title>Contact</title>

<?php

use App\Controllers\MessageController;

// CHECK IF FORM IS SUBMITTED
if (isset($_POST['submit']) && $_POST['action'] === 'newMessage') (new MessageController)->create();
?>

<!-- HEADER -->
<?php include './assets/components/front/header.php' ?>

<!-- MAIN CONTENT -->
<main>
    <div class="my-2 text-light">
        <div>
            <h1 class="text-center"><img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> MESSAGE PRIVÉ <img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>

        <div class="mx-auto py-4" style="background-color: rgb(0, 0, 0, 0.3)">
            <div class="card-body">
                <p class="card-text text-center text-warning">Vous avez des questions ou vous souhaitez simplement me contacter en privé ? Remplissez ce formulaire.</p>
                <?php
                if (isset($_SESSION['message']) && isset($_SESSION['messageSection'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message'], $_SESSION['messageSection']);
                };
                ?>
                <form action="" method="post" style="max-width:100%; width:40%;" class="form-group mx-auto">
                    <div class="row">
                        <input type="hidden" name="action" value="newMessage">
                        <input type="hidden" name="path" value=<?= $_SERVER['SCRIPT_NAME'] . '#messageForm' ?>>
                        <input type="hidden" name="isVisible" id="isVisible" value=0>

                        <div class="col-6">
                            <div>
                                <label for="last-name">Nom * :</label>
                                <input class="form-control pointer border border-dark my-1" type="text" name="last-name" id="last-name">
                            </div>
                            <div>
                                <label for="first-name">Prénom :</label>
                                <input class="form-control pointer border border-dark my-1" type="text" name="first-name" id="first-name">
                            </div>
                            <div>
                                <label for="email">Adresse email * :</label>
                                <input class="form-control pointer border border-dark my-1" type="email" name="email" id="email">
                            </div>
                        </div>

                        <div class="col-6">
                            <div>
                                <label for="company">Société :</label>
                                <input class="form-control pointer border border-dark my-1" type="text" name="company" id="company">
                            </div>
                            <div>
                                <label for="phone">Téléphone :</label>
                                <input class="form-control pointer border border-dark my-1" type="tel" name="phone" id="phone">
                            </div>
                        </div>

                        <div>
                            <label for="content">Message * :</label>
                            <textarea class="form-control pointer border border-dark my-1" name="content" id="content" rows="4"></textarea>
                        </div>

                        <div class="my-3 w-50 mx-auto">
                            <button type="submit" name="submit" class="btn btn-success border border-dark w-100">ENVOYER</button>
                        </div>
                        <p class="py-0 my-0">* : champ obligatoire</p>
                    </div>
                </form>
                <div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- FOOTER -->
<?php include './assets/components/front/footer.php' ?>