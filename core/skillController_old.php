<?php
// Ce fichier permet de récupérer, créer, modifier et supprimer une compétence

if (session_status() === 1) session_start();
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// IMPORT FONCTIONS GENERALES
require_once __DIR__ . DIRECTORY_SEPARATOR . 'generalController.php';

switch ($action) {
    case 'create':
        createSkill();
        break;
    case 'update':
        updateSkill($_POST['id']);
        break;
    case 'delete':
        deleteSkill($_POST['id']);
        break;
    default;
        break;
}

// FUNCTION GET ALL SKILLS (quand on récupère toutes les compétences)
function getAllSkills(string $statut = null): array
{
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    // Récupère seulement les compétences actives
    if ($statut === 'active') {
        $sql = "SELECT * FROM skill WHERE `active` = 1";
    } else {
        $sql = "SELECT * FROM skill";
    }
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    $skills = mysqli_fetch_all($query, MYSQLI_ASSOC);
    usort($skills, "sortById");
    return $skills;
}

// FUNCTION GET ONE SKILL (quand on récupère une compétence depuis son id)
function getOneSkill($id)
{
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    $sql = "SELECT * FROM skill WHERE id_skill = '$id'";
    $query = mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    return mysqli_fetch_assoc($query);
}

// FUNCTION CREATE (quand on crée une compétence)
function createSkill()
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    checkSkillForm('../admin/skill/createSkill.php');

    // Aucun nom d'image de base
    $imageName = '';

    // Vérifie si l'utilisateur a chargé un fichier
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {

        // Vérifie si le fichier chargé est une image
        if (strtolower(explode("/", $_FILES['image']['type'])[0]) === 'image') {
            $imageName = nameImage();
            saveImageToDisk($imageName);
        } else {
            redirectWithError('../admin/skill/createSkill.php', 'Erreur de fichier.');
        }
    }

    // CONNEXION BDD
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';

    // On récupère toutes les données du formulaire
    $title = strip_tags(ucwords(strtolower($_POST['title'])));
    $type = (int)$_POST['type'];
    $text = $_POST['text'];
    $image = $imageName;
    $link = $_POST['link'];
    $active = (int)$_POST['isActive'];

    // Création de la requête SQL avec les données ci-dessus
    $sql = "
    INSERT INTO skill (title,type,text,image,link,active)
    VALUE ('$title', '$type', '$text', '$image', '$link', '$active')
    ";

    // Envoie de la requête. Retourne une erreur si echoue
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    redirectWithSuccess('../admin/skill', "La compétence '$title' est ajoutée à la base de données.");
}

// FONCTION UPDATE (quand on modifie une compétence)
function updateSkill($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';

    checkSkillForm("../admin/skill/updateSkill.php?id=$id");

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
            deleteImageFromDisk($connexion, $id, 'skill');

            // Sauvegarde le nom de la nouvelle image en BDD
            $sql = "
                    UPDATE skill
                    SET image = '$newImageName'
                    WHERE id_skill = $id
                    ";
            mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
        } else {
            redirectWithError("../admin/skill/updateSkill.php?id=$id", 'Erreur de fichier.');
        }
    }

    // On récupère toutes les données du formulaire
    $title = strip_tags(ucwords(strtolower($_POST['title'])));
    $type = (int)$_POST['type'];
    $text = $_POST['text'];
    $link = $_POST['link'];
    $active = (int)$_POST['isActive'];

    // Requête SQL pour modifier la compétence
    $sql = "
        UPDATE skill
        SET title = '$title',
        type = '$type',
        text = '$text',
        link = '$link',
        active = '$active'
        WHERE id_skill = $id
    ";

    // Envoie de la requête
    // Retourne une erreur si la requête echoue
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));

    redirectWithSuccess("../admin/skill/detailSkill.php?id=$id", 'Compétence modifiée.');
}

// FONCTION DELETE (quand on supprime une compétence)
function deleteSkill($id)
{
    require __DIR__ . DIRECTORY_SEPARATOR . 'authentificationAdmin.php';
    require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'databaseConnexion.php';
    deleteImageFromDisk($connexion, $id, 'skill');
    $sql = "
    DELETE FROM skill
    WHERE id_skill = $id
    ";
    mysqli_query($connexion, $sql) or exit(mysqli_error($connexion));
    redirectWithSuccess('../admin/skill', "Compétence n°$id supprimée.");
}

// FONCTION CHECK FORM (vérifie la validité du formulaire, prend le chemin de redirection en param, en cas d'invalidité du form)
function checkSkillForm($redirectionPath)
{
    // Vérifie si les champs obligatoires sont remplis
    if (!$_POST['title']) redirectWithError($redirectionPath, 'Le titre est obligatoire.');
    if (!$_POST['type']) redirectWithError($redirectionPath, 'Le type est obligatoire.');

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

    // Vérifie la valeur du type
    if ($_POST['type'] !== '1' && $_POST['type'] !== '2') {
        redirectWithError($redirectionPath, 'Le type n\'est pas défini.');
    }

    // Vérifie si le statut est bien défini
    if ($_POST['isActive'] !== '0' && $_POST['isActive'] !== '1') {
        redirectWithError($redirectionPath, 'Le statut n\'est pas défini.');
    }
}
