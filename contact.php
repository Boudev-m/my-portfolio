<!-- PAGE DE CONTACT-->

<?php include './assets/inc/front/head.php' ?>
<title>Contact</title>

<?php
if (isset($_POST['submit']) && $_POST['action'] === 'contact') {
    if (!($_POST['name'] && $_POST['email'] && $_POST['message'])) {
        $_SESSION["message"] = '<p class="alert alert-danger fs-5 text-center p-1 w-50 mx-auto">Veuillez remplir tous les champs.</p>';
    } else {
        $_SESSION["message"] = '<p class="alert alert-success fs-5 text-center p-1 w-50 mx-auto">Votre formulaire a été envoyé.</p>';
    }
    exit(header('Location: ./contact.php'));
}
?>

<?php include './assets/inc/front/header.php' ?>

<main>

    <div class="my-2">
        <div class="border-bottom border-top border-dark">
            <h4 class="text-center pt-2">&#x260E; CONTACT &#x260E;</h4>
        </div>

        <div class="mx-auto py-4">
            <div class="card-body">
                <p class="card-text text-center">Vous avez des questions ou vous souhaitez simplement me contacter en privé ? Remplissez ce formulaire.</p>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                };
                ?>
                <form action="" method="post" style="width:40%" class="form-group mx-auto">
                    <input type="hidden" name="action" value="contact">
                    <label for="name">Nom :</label>
                    <input class="form-control my-2 pointer border border-dark" type="text" name="name" id="name">
                    <label for="email">Adresse email :</label>
                    <input class="form-control my-2 pointer border border-dark" type="email" name="email" id="email">
                    <label for="message">Message :</label>
                    <textarea class="form-control my-2 pointer border border-dark" name="message" id="message" rows="4" placeholder="Votre message"></textarea>
                    <button type="submit" name="submit" class="btn btn-success border border-dark w-100 my-2">ENVOYER</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include './assets/inc/front/footer.php' ?>