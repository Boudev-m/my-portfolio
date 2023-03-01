<?php
// MANAGE PROJECT
namespace App\Controllers;

use PDO;
use App\Models\Project;

if (session_status() === 1) session_start();

class ProjectController
{
    public function readAll(string $statut = null): array
    {
        // Récupère seulement les compétences actives
        if ($statut === 'active') {
            $sql = "SELECT * FROM project WHERE `active` = 1";
        } else {
            $sql = "SELECT * FROM project";
        }

        // require_once(__DIR__ . "/DatabaseConnection.php");  // Sert à récupérer $pdo. Il faut changer ce fichier en class
        // // global $pdo;
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, Project::class);  // ou "App\\Models\\Project" au lieu de Project::class
        return $result;

        // foreach ($result as $project) {
        //     $this->loadSkillsFromProject($project);
        // }

    }

    public function readOne($id): Project
    {
        $sql = "SELECT * FROM project WHERE id_project = :id";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Project::class);
        $result = $statement->fetch();

        return $result;

        // Requête de récupération des compétences (skills)
        // $this->loadSkillsFromProject($result);

    }

    public function create(): void
    {
        // Récupère les fonctions générales
        // require_once 'GeneralController.php';

        // Vérifie les données du formulaire
        $this->checkForm($_SERVER['SCRIPT_NAME']);

        // Vérifie si l'utilisateur a chargé un fichier
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {

            // Vérifie si le fichier chargé est une image
            if (strtolower(explode("/", $_FILES['image']['type'])[0]) !== 'image') {
                GeneralController::redirectWithError($_SERVER['SCRIPT_NAME'], 'Erreur de fichier.');
            } else {
                require_once 'ImageController.php';
                $imageName = ImageController::createName();
                ImageController::saveToDisk($imageName);
            }
        }

        // On récupère toutes les données du formulaire
        $title = strip_tags(ucwords(strtolower($_POST['title'])));
        $description = $_POST['description'] ?: null;
        $date_start = $_POST['date-start'];
        $date_end = $_POST['date-end'] ?: null;
        $image = $imageName ?? null;
        $link = $_POST['link'] ?: null;
        $active = (int)$_POST['isActive'];

        // Création de la requête SQL avec les données ci-dessus
        $sql = "
            INSERT INTO project (title, description, date_start, date_end, image, link, active)
            VALUES (:title, :description, :date_start, :date_end, :image, :link, :active)
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":date_start", $date_start);
        $statement->bindParam(":date_end", $date_end);
        $statement->bindParam(":image", $image);
        $statement->bindParam(":link", $link);
        $statement->bindParam(":active", $active);
        $statement->execute();

        GeneralController::redirectWithSuccess('../project', "La réalisation '$title' a été ajoutée.");
    }

    public function update($id): void
    {
        // Récupère les fonctions générales
        // require_once 'GeneralController.php';

        // Vérifie les données du formulaire
        $this->checkForm($_SERVER['REQUEST_URI']);

        // Connexion
        // global $pdo;

        // Vérifie si l'utilisateur a chargé un fichier
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {

            // Vérifie si le fichier chargé est une image
            if (strtolower(explode("/", $_FILES['image']['type'])[0]) !== 'image') {
                GeneralController::redirectWithError($_SERVER['SCRIPT_NAME'], 'Erreur de fichier.');
            } else {
                // require_once 'ImageController.php';
                // Sauvegarde l'image dans le disque
                $imageName = ImageController::createName();
                ImageController::saveToDisk($imageName);

                // Supprime l'ancienne image du disque (s'il y en a une)
                ImageController::removeFromDisk($id, 'project');

                // Met à jour l'image dans la BDD
                $sql = "
                    UPDATE project SET image = :image
                    WHERE id_project = :id
                ";
                $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
                $statement->bindParam(":id", $id);
                $statement->bindParam(":image", $imageName);
                $statement->execute();
            }
        }

        // On récupère toutes les données du formulaire
        $title = strip_tags(ucwords(strtolower($_POST['title'])));
        $description = $_POST['description'] ?: null;
        $date_start = $_POST['date-start'];
        $date_end = $_POST['date-end'] ?: null;
        $link = $_POST['link'] ?: null;
        $active = (int)$_POST['isActive'];

        // Création de la requête SQL avec les données ci-dessus
        $sql = "
            UPDATE project SET
            title = :title,
            description = :description,
            date_start = :date_start,
            date_end = :date_end,
            link = :link,
            active = :active
            WHERE id_project = :id
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":date_start", $date_start);
        $statement->bindParam(":date_end", $date_end);
        $statement->bindParam(":link", $link);
        $statement->bindParam(":active", $active);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../$id", "La réalisation '$title' a été modifiée.");
    }

    public function delete($id): void
    {
        // require_once 'GeneralController.php';
        // require_once 'ImageController.php';
        // global $pdo;
        ImageController::removeFromDisk($id, 'project');
        $sql = "
            DELETE FROM project
            WHERE id_project = :id
        ";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../", "La réalisation n°$id a été supprimée.");
    }

    public function checkForm($redirectionPath): void
    {
        // Vérifie si les champs obligatoires sont remplis
        if (!$_POST['title']) GeneralController::redirectWithError($redirectionPath, 'Le titre est obligatoire.');
        if (!$_POST['date-start']) GeneralController::redirectWithError($redirectionPath, 'La date de début est obligatoire.');

        // Vérifie la longueur des caractères saisies
        if (strlen($_POST['title']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le titre ne doit pas dépasser 255 caractères.');
        }
        if ($_POST['description'] && strlen($_POST['description']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'La description ne doit pas dépasser 255 caractères.');
        }
        if ($_POST['link'] && strlen($_POST['link']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le lien ne doit pas dépasser 255 caractères.');
        }

        // Vérifie si le statut est bien défini
        if ($_POST['isActive'] !== '0' && $_POST['isActive'] !== '1') {
            GeneralController::redirectWithError($redirectionPath, 'Le statut n\'est pas défini.');
        }

        // Vérifie si date de fin saisie
        if ($_POST['date-end']) {
            // Vérifie si date de fin > date de début
            if (strtotime($_POST['date-start']) > strtotime($_POST['date-end'])) {
                GeneralController::redirectWithError($redirectionPath, 'La date de fin ne peut être situé avant la date de début.');
            }
        }
    }

    // RECUPERE LES SKILLS LIéS AU PROJET
    // public function loadSkillsFromProject(Project $project)
    // {
    //     global $pdo;
    //     $sql = "SELECT 
    //         skill.id_skill, skill.name, skill.level, skill.picture
    //         FROM skill
    //         INNER JOIN skill_project ON skill_project.id_skill = skill.id_skill
    //         INNER JOIN project ON project.id_project = skill_project.id_project
    //         WHERE project.id_project = :id
    //     ";
    //     $statement = $pdo->prepare($sql);
    //     $statement->bindParam(":id", $project->id_project, PDO::PARAM_INT);
    //     $statement->execute();
    //     $project->skills = $statement->fetchAll(PDO::FETCH_CLASS, "SkillModel");
    // }
}
