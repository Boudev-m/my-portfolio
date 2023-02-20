<?php
// MANAGE SKILL

if (session_status() === 1) session_start();

require_once(__DIR__ . "/databaseConnection.php");
require_once(__DIR__ . "/../models/Skill.php");

class SkillController
{

    public function readAll(string $statut = null): array
    {
        // Récupère seulement les compétences actives
        if ($statut === 'active') {
            $sql = "SELECT * FROM skill WHERE `active` = 1";
        } else {
            $sql = "SELECT * FROM skill";
        }

        // Database connection
        global $pdo;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Skill");
        return $result;
    }

    public function readOne($id): Skill
    {

        $sql = "SELECT * FROM skill WHERE id_skill = :id";

        global $pdo;
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, "Skill");
        $result = $statement->fetch();

        return $result;
    }

    public function create(): void
    {
        // Récupère les fonctions générales
        require_once 'generalController.php';

        // Vérifie les données du formulaire
        $this->checkForm($_SERVER['SCRIPT_NAME']);

        // Vérifie si l'utilisateur a chargé un fichier
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {

            // Vérifie si le fichier chargé est une image
            if (strtolower(explode("/", $_FILES['image']['type'])[0]) !== 'image') {
                GeneralController::redirectWithError($_SERVER['SCRIPT_NAME'], 'Erreur de fichier.');
            } else {
                $imageName = GeneralController::createImageName();
                GeneralController::saveImageToDisk($imageName);
            }
        }

        // On récupère toutes les données du formulaire
        $title = strip_tags(ucwords(strtolower($_POST['title'])));
        $type = (int)$_POST['type'];
        $text = $_POST['text'] ?: null;
        $image = $imageName ?: null;
        $link = $_POST['link'] ?: null;
        $active = (int)$_POST['isActive'];

        // Création de la requête SQL avec les données ci-dessus
        $sql = "
            INSERT INTO skill (title, type, text, image, link, active)
            VALUES (:title, :type, :text, :image, :link, :active)
        ";

        global $pdo;
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":type", $type);
        $statement->bindParam(":text", $text);
        $statement->bindParam(":image", $image);
        $statement->bindParam(":link", $link);
        $statement->bindParam(":active", $active);
        $statement->execute();

        GeneralController::redirectWithSuccess('../skill', "La compétence '$title' est ajoutée à la base de données.");
    }

    public function update($id): void
    {
        // Récupère les fonctions générales
        require_once 'generalController.php';

        // Vérifie les données du formulaire
        $this->checkForm($_SERVER['REQUEST_URI']);

        // Connexion
        global $pdo;

        // Vérifie si l'utilisateur a chargé un fichier
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {

            // Vérifie si le fichier chargé est une image
            if (strtolower(explode("/", $_FILES['image']['type'])[0]) !== 'image') {
                GeneralController::redirectWithError($_SERVER['SCRIPT_NAME'], 'Erreur de fichier.');
            } else {
                // Sauvegarde l'image dans le disque
                $imageName = GeneralController::createImageName();
                GeneralController::saveImageToDisk($imageName);

                // Supprime l'ancienne image du disque (s'il y en a une)
                GeneralController::removeImageFromDisk($pdo, $id, 'skill');

                // Met à jour l'image dans la BDD
                $sql = "
                    UPDATE skill SET image = :image
                    WHERE id_skill = :id
                ";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(":id", $id);
                $statement->bindParam(":image", $imageName);
                $statement->execute();
            }
        }

        // On récupère toutes les données du formulaire
        $title = strip_tags(ucwords(strtolower($_POST['title'])));
        $type = (int)$_POST['type'];
        $text = $_POST['text'] ?: null;
        $link = $_POST['link'] ?: null;
        $active = (int)$_POST['isActive'];

        // Création de la requête SQL avec les données ci-dessus
        $sql = "
            UPDATE skill SET
            title = :title,
            type = :type,
            text = :text,
            link = :link,
            active = :active
            WHERE id_skill = :id
        ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":type", $type);
        $statement->bindParam(":text", $text);
        $statement->bindParam(":link", $link);
        $statement->bindParam(":active", $active);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("detailSkill.php?id=$id", "La compétence '$title' a été modifiée.");
    }

    public function delete($id): void
    {
        require_once 'generalController.php';
        global $pdo;
        GeneralController::removeImageFromDisk($pdo, $id, 'skill');
        $sql = "
            DELETE FROM skill
            WHERE id_skill = :id
        ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../skill", "La compétence n°$id a été supprimée.");
    }

    public function checkForm($redirectionPath): void
    {
        // Vérifie si les champs obligatoires sont remplis
        if (!$_POST['title']) GeneralController::redirectWithError($redirectionPath, 'Le titre est obligatoire.');
        if (!$_POST['type']) GeneralController::redirectWithError($redirectionPath, 'Le type est obligatoire.');

        // Vérifie la longueur des caractères saisies
        if (strlen($_POST['title']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le titre ne doit pas dépasser 255 caractères.');
        }
        if ($_POST['text'] && strlen($_POST['text']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le texte ne doit pas dépasser 255 caractères.');
        }
        if ($_POST['link'] && strlen($_POST['link']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le lien ne doit pas dépasser 255 caractères.');
        }

        // Vérifie la valeur du type
        if ($_POST['type'] !== '1' && $_POST['type'] !== '2') {
            GeneralController::redirectWithError($redirectionPath, 'Le type n\'est pas défini.');
        }

        // Vérifie si le statut est bien défini
        if ($_POST['isActive'] !== '0' && $_POST['isActive'] !== '1') {
            GeneralController::redirectWithError($redirectionPath, 'Le statut n\'est pas défini.');
        }
    }
}
