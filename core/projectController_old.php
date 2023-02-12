<?php
// Ce fichier permet de récupérer, créer, modifier et supprimer un projet/une réalisation

if (session_status() === 1) session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// IMPORT FONCTIONS GENERALES
require_once __DIR__ . DIRECTORY_SEPARATOR . 'generalController.php';

switch ($action) {
    case 'create':
        createProject();
        break;
    case 'update':
        updateProject($_POST['id']);
        break;
    case 'delete':
        deleteProject($_POST['id']);
        break;
    default;
        break;
}

// FUNCTION GET ALL PROJECTS
function getAllProjects(string $statut = null): array
{
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    // Récupère seulement les compétences actives
    if ($statut === 'active') {
        $sql = "SELECT * FROM project WHERE `active` = 1";
    } else {
        $sql = "SELECT * FROM project";
    }
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    $projects = mysqli_fetch_all($query, MYSQLI_ASSOC);
    usort($projects, "sortById");
    return $projects;
}

// FUNCTION GET ONE PROJECT
function getOneProject($id)
{
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    $sql = "SELECT * FROM project WHERE id_project = '$id'";
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    return mysqli_fetch_assoc($query);
}

// FUNCTION CREATE
function createProject()
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    checkProjectForm('../admin/project/createProject.php');

    // Aucun nom d'image de base
    $imageName = '';

    // Vérifie si l'utilisateur a chargé un fichier
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {

        // Vérifie si le fichier chargé est une image
        if (strtolower(explode("/", $_FILES['image']['type'])[0]) === 'image') {
            $imageName = nameImage();
            saveImageToDisk($imageName);
        } else {
            redirectWithError('../admin/project/createProject.php', 'Erreur de fichier.');
        }
    }

    // CONNEXION BDD
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    // On récupère toutes les données du formulaire
    $title = strip_tags(ucwords(strtolower($_POST['title'])));
    $text = $_POST['text'];
    $date_start = $_POST['date-start'];
    $date_end = $_POST['date-end'];
    $date_end = !empty($date_end) ? "'$date_end'" : "NULL";     // prop nullable
    $image = $imageName;
    $link = $_POST['link'];
    $active = (int)$_POST['isActive'];

    // Création de la requête SQL avec les données ci-dessus

    $sql = "
    INSERT INTO project (title, text, date_start, date_end, image, link, active)
    VALUE ('$title', '$text', '$date_start', $date_end, '$image', '$link', '$active')
    ";

    // Envoie de la requête. Retourne une erreur si echoue
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    redirectWithSuccess('../admin/project', "La réalisation '$title' a été ajoutée.");
}

// FONCTION UPDATE (quand on modifie une réalisation)
function updateProject($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    checkProjectForm("../admin/project/updateProject.php?id=$id");

    // CONNEXION BDD
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    // Vérifie si l'utilisateur a chargé un fichier
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {

        // Vérifie si le fichier chargé est une image
        if (strtolower(explode("/", $_FILES['image']['type'])[0]) === 'image') {

            // Nomme la nouvelle image
            $newImageName = nameImage();

            // Sauvegarde la nouvelle image sur le disque
            saveImageToDisk($newImageName);

            // Supprime l'ancienne image du disque
            deleteImageFromDisk($connexion, $id, 'project');

            // Sauvegarde le nom de la nouvelle image en BDD
            $sql = "
                    UPDATE project
                    SET image = '$newImageName'
                    WHERE id_project = $id
                    ";
            mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
        } else {
            redirectWithError("../admin/project/updateProject.php?id=$id", 'Erreur de fichier.');
        }
    }

    // On récupère toutes les données du formulaire
    $title = strip_tags(ucwords(strtolower($_POST['title'])));
    $text = $_POST['text'];
    $date_start = $_POST['date-start'];
    $date_end = $_POST['date-end'];
    $date_end = !empty($date_end) ? "'$date_end'" : "NULL";
    $link = $_POST['link'];
    $active = (int)$_POST['isActive'];

    // Requête SQL pour modifier la réalisation
    $sql = "
        UPDATE project
        SET title = '$title',
        text = '$text',
        date_start = '$date_start',
        date_end = $date_end,
        link = '$link',
        active = '$active'
        WHERE id_project = $id
    ";

    // Envoie de la requête
    // Retourne une erreur si la requête echoue
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    redirectWithSuccess("../admin/project/detailProject.php?id=$id", 'Réalisation modifiée.');
}

// FONCTION DELETE (quand on supprime une réalisation)
function deleteProject($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    deleteImageFromDisk($connexion, $id, 'project');
    $sql = "
    DELETE FROM project
    WHERE id_project = $id
    ";
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    redirectWithSuccess('../admin/project', "Réalisation n°$id supprimée.");
}

// FONCTION CHECK FORM (vérifie la validité du formulaire, prend le chemin de redirection en param, en cas d'invalidité du form)
function checkProjectForm($redirectionPath)
{
    // Vérifie si les champs obligatoires sont remplis
    if (!$_POST['title']) redirectWithError($redirectionPath, 'Le titre est obligatoire.');
    if (!$_POST['date-start']) redirectWithError($redirectionPath, 'La date de début est obligatoire.');

    // Vérifie la longueur des caractères saisies
    if (strlen($_POST['title']) > 255) {
        redirectWithError($redirectionPath, 'Le titre ne doit pas dépasser 255 caractères.');
    }
    if ($_POST['text'] && strlen($_POST['text']) > 255) {
        redirectWithError($redirectionPath, 'Le texte ne doit pas dépasser 255 caractères.');
    }
    if ($_POST['link'] && strlen($_POST['link']) > 255) {
        redirectWithError($redirectionPath, 'Le lien ne doit pas dépasser 255 caractères.');
    }

    // Vérifie si le statut est bien défini
    if ($_POST['isActive'] !== '0' && $_POST['isActive'] !== '1') {
        redirectWithError($redirectionPath, 'Le statut n\'est pas défini.');
    }

    // vérifier le type date de la date_start (et date_end si saisie)

    // Si date_end saisie, vérifier que date_start < date_end
}
