<?php
// Ce fichier permet de récupérer, créer, modifier et supprimer un message

if (session_status() === 1) session_start();

$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// IMPORT FONCTIONS GENERALES
require_once __DIR__ . DIRECTORY_SEPARATOR . 'generalController.php';

switch ($action) {
    case 'create':
        createMessage();
        break;
    case 'update':
        updateMessage($_POST['id']);
        break;
    case 'delete':
        deleteMessage($_POST['id']);
        break;
    default;
        break;
}

// FUNCTION GET ALL MESSAGES (quand on récupère tous les messages)
function getAllMessages()
{
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    $sql = "SELECT * FROM message ORDER BY `created_at` DESC";
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    return mysqli_fetch_all($query, MYSQLI_ASSOC);
}

// FUNCTION GET ONE MESSAGE (quand on récupère un message depuis son id)
function getOneMessage($id)
{
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    $sql = "SELECT * FROM message WHERE id = '$id'";
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    return mysqli_fetch_assoc($query);
}

// FUNCTION CREATE (quand on crée un message)
function createMessage()
{
    // Cette action ne requiert pas d'authentification
    // require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    // Permet d'afficher le message dans la section message
    $_SESSION['messageSection'] = true;

    checkMessageForm($_POST['path']);

    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    $firstName = htmlspecialchars(addslashes(trim(ucfirst($_POST["first_name"]))));
    $lastName = htmlspecialchars(addslashes(trim(ucfirst($_POST["last_name"]))));
    $email = htmlspecialchars(trim(strtolower($_POST["email"])));
    $company = htmlspecialchars(addslashes(trim(ucfirst($_POST["company"]))));
    $phone = htmlspecialchars(addslashes(trim($_POST['phone'])));
    $message = htmlspecialchars(addslashes(trim($_POST["message"])));

    $sql = "
    INSERT INTO message (first_name,last_name,email,company,phone,text,created_at)
    VALUE ('$firstName', '$lastName', '$email', '$company', '$phone', '$message', NOW())
    ";

    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    redirectWithSuccess($_POST['path'], "Votre message a été ajouté.");
}

// FONCTION UPDATE (quand on modifie un message)
function updateMessage($id)
{
    // exit(var_dump($_POST));
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    checkMessageForm($_POST['path']);

    // CONNEXION BDD
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    // On formatte les données
    $firstName = htmlspecialchars(addslashes(trim(ucfirst($_POST["first_name"]))));
    $lastName = htmlspecialchars(addslashes(trim(ucfirst($_POST["last_name"]))));
    $email = htmlspecialchars(trim(strtolower($_POST["email"])));
    $company = htmlspecialchars(addslashes(trim(ucfirst($_POST["company"]))));
    $phone = htmlspecialchars(addslashes(trim($_POST['phone'])));
    $message = htmlspecialchars(addslashes(trim($_POST["message"])));

    // Requête SQL pour modifier le message
    $sql = "
        UPDATE message
        SET first_name = '$firstName',
        last_name = '$lastName',
        email = '$email',
        company = '$company',
        phone = '$phone',
        text = '$message'
        WHERE id = $id
    ";

    // Envoie de la requête
    // Retourne une erreur si la requête echoue
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    redirectWithSuccess("../admin/message/detailMessage.php?id=$id", 'Message modifié.');
}

// FONCTION DELETE (quand on supprime un message)
function deleteMessage($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    $sql = "
    DELETE FROM message
    WHERE id = $id
    ";
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    redirectWithSuccess('../admin/message', "Message n°$id supprimé.");
}

// FONCTION CHECK FORM (vérifie la validité du formulaire, prend le chemin de redirection en param, en cas d'invalidité du form)
function checkMessageForm($redirectionPath)
{
    // Vérifie si les champs obligatoires sont remplis
    if (!$_POST['last_name']) redirectWithError($redirectionPath, 'Le nom est obligatoire.');
    if (!$_POST['first_name']) redirectWithError($redirectionPath, 'Le prénom est obligatoire.');
    if (!$_POST['email']) redirectWithError($redirectionPath, 'L\'adresse email est obligatoire.');
    if (!$_POST['message']) redirectWithError($redirectionPath, 'Le message est obligatoire.');

    // Vérifie le format d'écriture de l'email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        redirectWithError($redirectionPath, 'Email non valide');
    }

    // Vérifie la longueur des caractères saisies
    if (strlen($_POST['last_name']) > 255) {
        redirectWithError($redirectionPath, 'Le nom doit comporter entre 1 et 255 caractères');
    }
    if (strlen($_POST['first_name']) > 255) {
        redirectWithError($redirectionPath, 'Le prénom doit comporter entre 1 et 255 caractères');
    }
    if (strlen($_POST['email']) > 255) {
        redirectWithError($redirectionPath, 'L\'email doit comporter entre 1 et 255 caractères');
    }
    if (strlen($_POST['message']) > 1000) {
        redirectWithError($redirectionPath, 'Le message ne doit pas dépasser 1000 caractères.');
    }
    if ($_POST['phone'] && strlen($_POST['phone']) > 255) {
        redirectWithError($redirectionPath, 'Le n° téléphone ne doit pas dépasser 255 caractères.');
    }
}
