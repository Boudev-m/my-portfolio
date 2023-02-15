<?php

// Ce fichier permet de :
// - logger l'user en récupérant les champs du formulaire admin/index.php
// - deconnecter l'user en cliquant le bouton 'deconnecter'
// - récupérer, créer, modifier et supprimer un user

// Démarre la session si aucune existe
if (session_status() === 1) session_start();

// Aucune action n'est programmée au départ (on initialise la var)
$action = '';

// Vérifie si la clé 'action' est présente dans $_POST (contient la nature de l'action dans la value du input hidden)
if (isset($_POST['action'])) {
    // On récupère la valeur et on la sauvegarde dans $action
    $action = $_POST['action'];
}

// IMPORT FONCTIONS GENERALES
require_once __DIR__ . DIRECTORY_SEPARATOR . 'generalController.php';

// Execute une fonction selon la nature de l'action
switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'create':
        createUser();
        break;
    case 'update':
        updateUser($_POST['id']);
        break;
    case 'delete':
        deleteUser($_POST['id']);
        break;
    default;
        break;
}

// FONCTION LOGIN (quand l'utilisateur se connecte)
function login()
{
    // Vérifie si un des champs est vide
    if (!$_POST['email'] || !$_POST['password']) {
        redirectWithError('../admin/index.php', 'Veuillez remplir tous les champs.');
    }

    // Fichier databaseConnexion.php requis pour la connexion
    require './databaseConnexion.php';

    // formatage du mail
    $email = trim(strtolower($_POST['email']));

    // Vérifie l'email de l'admin (unique). le champ email possède une clé unique dans la BDD
    // Préparation de la requête : vérifie si l'email est présente 
    $sql = "
    SELECT * FROM user WHERE email = '$email'
    ";

    // Execution de la requête avec les params de connexion et sauvegarde la reponse dans $query
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    // Traitement des données : vérification de l'email dans la BDD
    // On utilise mysqli_num_row qui compte le nombre de lignes dans la table user

    // S'il n'y a pas d'utilisateur dans la BDD 
    if (mysqli_num_rows($query) < 1) {
        redirectWithError('../admin/index.php', 'Aucun compte ne correspond.');
    }

    // Sinon on met sous forme de tableau associatif les données de l'admin récupérés
    $user = mysqli_fetch_assoc($query);

    // Vérification password
    if (!password_verify(trim($_POST['password']), $user['password'])) {
        redirectWithError('../admin/index.php', 'Mot de pase incorrect.');
    }

    // Vérification role (1 = Admin)
    // if ((int)$user['role'] !== 1) {
    //     var_dump('ok');
    //     exit;
    //     redirectWithError('../index.php', 'Accès refusé.');
    // }

    // Sinon la connexion est réussie
    // on sauvegarde des données dans la session (qui permettent de donner accès au back-office)
    // puis redirige l'admin au tableau de bord
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['isLog'] = true;
    $_SESSION['role'] = $user['role'];
    redirectWithSuccess('../admin/dashboardAdmin.php', "Bonjour {$user['first_name']} {$user['last_name']}.");
}

// FONCTION LOGOUT (quand l'utilisateur se déconnecte)
function logout()
{
    // supprime la session courante et toutes les données en session
    session_destroy();
    session_start();
    redirectWithSuccess('../index.php', 'Vous vous êtes déconnecté.');
}

// FUNCTION GET ALL USERS (quand on récupère tous les utilisateurs)
function getAllUsers()
{
    // Fichier databaseConnexion.php requis pour la connexion à la BDD
    require '../../core/databaseConnexion.php';

    // Préparation de la requête : Récupérer toutes les lignes de la table user
    $sql = "SELECT * FROM user";

    // Execution de la requête avec les params de connexion et sauvegarde la reponse dans $query
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    // Récupère la table user sous forme de tableau associatif et exploitable
    $users = mysqli_fetch_all($query, MYSQLI_ASSOC);

    // Trie les utilisateurs par id
    usort($users, "sortById");

    // Retourne les users
    return $users;
}

// FUNCTION GET ONE USER (quand on récupère un utilisateur depuis son id)
function getOneUser($id)
{
    // Fichier databaseConnexion.php requis pour la connexion à la BDD
    require '../../core/databaseConnexion.php';

    // Préparation de la requête : Récupère la ligne correspondant à l'id dans la table user
    $sql = "SELECT * FROM user WHERE id_user = '$id'";

    // Execution de la requête avec les params de connexion et sauvegarde la reponse dans $query
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    // Retourn les données sous forme de tableau associatif et exploitable
    return mysqli_fetch_assoc($query);
}

// FUNCTION CREATE (quand on crée un utilisateur)
function createUser()
{
    // Vérifie l'authentification admin
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    // Vérifie la validité du formulaire
    checkUserForm('../admin/user/createUser.php');

    // on récupère le fichier de connexion databaseConnexion.php qui correspond aux params de connexion de la bdd
    require_once '../core/databaseConnexion.php';

    // addslashes prend en compte les caract spec, trim supprime les espaces, ucfirst met la 1ere lettre en maj
    // strtolower pour mettre en min
    $first_name = strip_tags(addslashes(trim(ucfirst($_POST['first_name']))));
    $last_name = strip_tags(addslashes(trim(ucfirst($_POST['last_name']))));
    $email = strip_tags(trim(strtolower($_POST['email'])));
    $password = strip_tags(password_hash(trim($_POST['password']), PASSWORD_BCRYPT, ['cost' => 12]));
    $profile = (int)$_POST['profile'];
    $role = (int)$_POST['role']; // role 1 = Admin. role 2 = utilisateur

    // Création de la requête SQL pour enregistrer l'utilisateur
    $sql = "
    INSERT INTO user (first_name,last_name,email,password,profile,role)
    VALUE ('$first_name', '$last_name', '$email', '$password', '$profile', '$role')
    ";

    // Execute la requête : soit réussi ou soit appel la fonction catchSqlError en cas d'echec
    mysqli_query($connexion, $sql) or catchSqlError($connexion, '../admin/user/createUser.php');

    redirectWithSuccess('../admin/user', "L'utilisateur $first_name $last_name a été ajouté.");
}

// FONCTION UPDATE (quand on modifie un utilisateur)
function updateUser($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    checkUserForm("../admin/user/updateUser.php?id=$id");

    // Récupère le fichier de connexion database
    require_once '../core/databaseConnexion.php';

    // addslashes prend en compte les caract spec, trim supprime les espaces, ucfirst met la 1ere lettre en maj
    // strtolower pour mettre en min
    $first_name = strip_tags(addslashes(trim(ucfirst($_POST["first_name"]))));
    $last_name = strip_tags(addslashes(trim(ucfirst($_POST["last_name"]))));
    $email = strip_tags(trim(strtolower($_POST["email"])));
    $password = strip_tags(password_hash(trim($_POST['password']), PASSWORD_BCRYPT, ['cost' => 12]));
    $profile = (int)$_POST['profile'];
    $role = (int)$_POST["role"];

    // Requête SQL pour modifier l'utilisateur
    $sql = "
        UPDATE user
        SET first_name = '$first_name',
        last_name = '$last_name',
        email = '$email',
        password = '$password',
        profile = '$profile',
        role = '$role'
        WHERE id_user = $id
    ";

    // Envoie de la requête
    // Retourne une erreur si la requête echoue
    mysqli_query($connexion, $sql) or catchSqlError($connexion, "../admin/user/updateUser.php?id=$id");

    redirectWithSuccess("../admin/user/detailUser.php?id=$id", 'Compte utilisateur modifié.');
}

// FONCTION DELETE (quand on supprime un utilisateur)
function deleteUser($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    require_once '../core/databaseConnexion.php';

    // Préparation de la requête : Récupère la ligne correspondant à l'id dans la table user
    $sql = "SELECT * FROM user WHERE id_user = '$id'";
    // Execution de la requête avec les params de connexion et sauvegarde la reponse dans $query
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    $user = mysqli_fetch_assoc($query);

    // Vérifie si le compte à supprimer est Admin
    if ($user['role'] === '1') {
        redirectWithError('../admin/user', 'Vous ne pouvez pas supprimer un compte administrateur.');
    } else {
        // Requête SQL pour supprimer l'utilisateur
        $sql = "
            DELETE FROM user
            WHERE id_user = $id
        ";

        // Execution de la requête ou retourne erreur
        mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

        redirectWithSuccess('../admin/user', "Compte utilisateur n°$id supprimé.");
    }
}

// FONCTION CHECK FORM (vérifie la validité du formulaire, prend le chemin de redirection en param, en cas d'invalidité du form)
function checkUserForm($redirectionPath)
{
    // Vérifie si tous les champs du formulaire sont remplis
    if (!$_POST['last_name'] || !$_POST['first_name'] || !$_POST['email'] || !$_POST['role'] || !$_POST['password']) {
        redirectWithError($redirectionPath, 'Veuillez remplir tous les champs.');
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
    if (strlen($_POST['password']) > 255) {
        redirectWithError($redirectionPath, 'Le nom doit comporter entre 1 et 255 caractères');
    }

    // Vérifie le format d'écriture de l'email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        redirectWithError($redirectionPath, 'Email non valide');
    }

    // Vérifie si la photo de profil est bien définie
    if (!isset($_POST['profile']) || (int)$_POST['profile'] < 1 || 9 < (int)$_POST['profile']) {
        redirectWithError($redirectionPath, 'La photo de profil n\'est pas définie.');
    }

    // Vérifie si le rôle est bien défini
    if ($_POST['role'] !== '1' && $_POST['role'] !== '2') {
        redirectWithError($redirectionPath, 'Le rôle n\'est pas défini.');
    }
}
