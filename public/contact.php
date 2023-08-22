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
    <div class="my-2">
        <div>
            <h1 class="text-center mt-4"><img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon'> MESSAGE PRIVÉ <img src="./assets/images/icons/arrow.svg" alt="arrow icon" class='align-bottom arrow-icon reverse'></h1>
        </div>

        <div class="mx-auto py-4" style="background-color: rgb(0, 0, 0, 0.1)">
            <div class="card-body">
                <p class="card-text text-center">Vous avez des questions ou vous souhaitez simplement me contacter en privé ? Remplissez ce formulaire.</p>
                <?php
                if (isset($_SESSION['message']) && isset($_SESSION['messageSection'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message'], $_SESSION['messageSection']);
                };
                ?>
                <form action="" method="post" class="form-group form-contact mx-auto">
                    <div class="mx-auto row col-10 col-sm-8 col-md-6 col-xl-5">
                        <input type="hidden" name="action" value="newMessage">
                        <input type="hidden" name="path" value=<?= $_SERVER['SCRIPT_NAME'] . '#messageForm' ?>>
                        <input type="hidden" name="isVisible" id="isVisible" value=0>

                        <div class="col-lg-6">
                            <div>
                                <label for="last-name">Nom * :</label>
                                <input class="form-control pointer border border-dark my-1 rounded-0" type="text" name="last-name" id="last-name" style="background: #EEE">
                            </div>
                            <div>
                                <label for="first-name">Prénom :</label>
                                <input class="form-control pointer border border-dark my-1 rounded-0" type="text" name="first-name" id="first-name" style="background: #EEE">
                            </div>
                            <div>
                                <label for="email">Adresse email * :</label>
                                <input class="form-control pointer border border-dark my-1 rounded-0" type="text" name="email" id="email" style="background: #EEE">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <label for="company">Société :</label>
                                <input class="form-control pointer border border-dark my-1 rounded-0" type="text" name="company" id="company" style="background: #EEE">
                            </div>
                            <div>
                                <label for="phone">Téléphone :</label>
                                <input class="form-control pointer border border-dark my-1 rounded-0" type="tel" name="phone" id="phone" style="background: #EEE">
                            </div>
                        </div>

                        <div>
                            <label for="content">Message * :</label>
                            <textarea class="form-control pointer border border-dark my-1 rounded-0" name="content" id="content" rows="4" style="background: #EEE"></textarea>
                        </div>

                        <div class="my-3 w-50 mx-auto">
                            <button type="submit" name="submit" class="btn btn-success border border-dark w-100">ENVOYER</button>
                        </div>
                        <p class="text-center text-sm-start py-0 my-0">* : champ obligatoire</p>
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