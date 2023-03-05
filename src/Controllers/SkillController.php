<?php
// SKILL CONTROLLER

namespace App\Controllers;

use PDO;
use App\Models\Skill;

class SkillController
{
    // GET ALL SKILLS FROM DATABASE
    public function readAll(string $statut = null): array
    {
        // get only active skills if 'active' is in arg, or get all skills
        $sql = $statut === 'active' ? "SELECT * FROM skill WHERE `active` = 1" : "SELECT * FROM skill";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        $skills = $statement->fetchAll(PDO::FETCH_CLASS, Skill::class);
        return $skills;
    }

    // GET ONE SKILL
    public function readOne(int $id): Skill
    {
        $sql = "SELECT * FROM skill WHERE id_skill = :id";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Skill::class);
        $skill = $statement->fetch();

        if (!$skill) GeneralController::redirectWithError('../', 'La ressource que vous recherchez n\'existe pas.');

        return $skill;
    }

    // CREATE SKILL
    public function create(): void
    {
        // check if form valid
        $this->checkForm($_SERVER['SCRIPT_NAME']);

        // check if file uploaded
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {

            // check if the file uploaded is an image
            if (strtolower(explode("/", $_FILES['image']['type'])[0]) !== 'image') {
                GeneralController::redirectWithError($_SERVER['SCRIPT_NAME'], 'Erreur de fichier.');
            } else {
                // create name for the image and save to disk
                $imageName = ImageController::createName();
                ImageController::saveToDisk($imageName);
            }
        }

        // formatting datas
        $title = strip_tags(ucwords(strtolower($_POST['title'])));
        $type = (int)$_POST['type'];
        $description = $_POST['description'] ?: null;
        $image = $imageName ?? null;
        $link = $_POST['link'] ?: null;
        $active = (int)$_POST['isActive'];

        // save skill in DB
        $sql = "
            INSERT INTO skill (title, type, description, image, link, active)
            VALUES (:title, :type, :description, :image, :link, :active)
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":type", $type);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":image", $image);
        $statement->bindParam(":link", $link);
        $statement->bindParam(":active", $active);
        $statement->execute();

        GeneralController::redirectWithSuccess('../skill', "La compétence '$title' a été ajoutée.");
    }

    // UPDATE SKILL
    public function update(int $id): void
    {
        // check if form valid
        $this->checkForm($_SERVER['REQUEST_URI']);

        // check if file uploaded
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {

            // check if the file uploaded is an image
            if (strtolower(explode("/", $_FILES['image']['type'])[0]) !== 'image') {
                GeneralController::redirectWithError($_SERVER['SCRIPT_NAME'], 'Erreur de fichier.');
            } else {
                // create name for the image and save to disk
                $imageName = ImageController::createName();
                ImageController::saveToDisk($imageName);

                // remove the old image (if there is one)
                ImageController::removeFromDisk($id, 'skill');

                // update image in DB
                $sql = "UPDATE skill SET image = :image WHERE id_skill = :id";
                $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
                $statement->bindParam(":id", $id);
                $statement->bindParam(":image", $imageName);
                $statement->execute();
            }
        }

        // formatting datas
        $title = strip_tags(ucwords(strtolower($_POST['title'])));
        $type = (int)$_POST['type'];
        $description = $_POST['description'] ?: null;
        $link = $_POST['link'] ?: null;
        $active = (int)$_POST['isActive'];

        // Update skill in DB
        $sql = "
            UPDATE skill SET
            title = :title,
            type = :type,
            description = :description,
            link = :link,
            active = :active
            WHERE id_skill = :id
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":type", $type);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":link", $link);
        $statement->bindParam(":active", $active);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../$id", "La compétence '$title' a été modifiée.");
    }

    // DELETE SKILL
    public function delete(int $id): void
    {
        // remove the old image (if there is one)
        ImageController::removeFromDisk($id, 'skill');

        // delete skill in DB
        $sql = "DELETE FROM skill WHERE id_skill = :id";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../", "La compétence n°$id a été supprimée.");
    }

    // CHECK FORM
    public function checkForm(string $redirectionPath): void
    {
        // check if required fields are filled
        if (!$_POST['title']) GeneralController::redirectWithError($redirectionPath, 'Le titre est obligatoire.');
        if (!$_POST['type']) GeneralController::redirectWithError($redirectionPath, 'Le type est obligatoire.');

        // check character length
        if (strlen($_POST['title']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le titre ne doit pas dépasser 255 caractères.');
        }
        if ($_POST['description'] && strlen($_POST['description']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'La description ne doit pas dépasser 255 caractères.');
        }
        if ($_POST['link'] && strlen($_POST['link']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le lien ne doit pas dépasser 255 caractères.');
        }

        // check if type is set
        if ($_POST['type'] !== '1' && $_POST['type'] !== '2') {
            GeneralController::redirectWithError($redirectionPath, 'Le type n\'est pas défini.');
        }

        // check if statut is set
        if ($_POST['isActive'] !== '0' && $_POST['isActive'] !== '1') {
            GeneralController::redirectWithError($redirectionPath, 'Le statut n\'est pas défini.');
        }
    }
}
