<?php
// MESSAGE CONTROLLER

namespace App\Controllers;

use PDO;
use App\Models\Message;

class MessageController
{
    // GET ALL MESSAGES FROM DATABASE
    public function readAll(string $statut = null): array
    {
        // get only visible messages if 'visible' is in arg, or get all messages
        $sql = $statut === 'visible' ? "SELECT * FROM message WHERE `visible` = 1" : "SELECT * FROM message";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        $messages = $statement->fetchAll(PDO::FETCH_CLASS, Message::class);
        return $messages;
    }

    // GET ONE MESSAGE
    public function readOne(int $id): Message
    {
        $sql = "SELECT * FROM message WHERE id_message = :id";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Message::class);
        $message = $statement->fetch();

        if (!$message) GeneralController::redirectWithError('../', 'La ressource que vous recherchez n\'existe pas.');

        return $message;
    }

    // CREATE MESSAGE
    public function create(): void
    {
        // Display alert message in the message section in home page
        $_SESSION['messageSection'] = true;

        // check if form valid
        $this->checkForm($_POST['path']);

        // formatting datas
        $lastName = htmlspecialchars(addslashes(trim(ucfirst($_POST['last-name']))));
        $firstName = htmlspecialchars(addslashes(trim(ucfirst($_POST['first-name'])))) ?: null;
        $email = htmlspecialchars(trim(strtolower($_POST['email'])));
        $company = htmlspecialchars(addslashes(trim(ucfirst($_POST['company'])))) ?: null;
        $phone = htmlspecialchars(addslashes(trim($_POST['phone']))) ?: null;
        $content = htmlspecialchars(trim($_POST['content']));
        $visible = (int)$_POST['isVisible'];

        // save message in DB
        $sql = "
        INSERT INTO message (first_name, last_name, email, company, phone, content, created_at, visible)
        VALUES (:first_name, :last_name, :email, :company, :phone, :content, NOW(), :visible)
        ";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":first_name", $firstName);
        $statement->bindParam(":last_name", $lastName);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":company", $company);
        $statement->bindParam(":phone", $phone);
        $statement->bindParam(":content", $content);
        $statement->bindParam(":visible", $visible);
        $statement->execute();

        $sentence = (int)$visible === 1 ? 'Message publié.' : 'Votre message a été envoyé.';
        GeneralController::redirectWithSuccess($_POST['path'], $sentence);
    }

    // UPDATE MESSAGE
    public function update(int $id): void
    {
        // check if form valid
        $this->checkForm($_SERVER['REQUEST_URI']);

        // formatting datas
        $firstName = htmlspecialchars(addslashes(trim(ucfirst($_POST['first-name']))));
        $lastName = htmlspecialchars(addslashes(trim(ucfirst($_POST['last-name']))));
        $email = htmlspecialchars(trim(strtolower($_POST['email'])));
        $company = htmlspecialchars(addslashes(trim(ucfirst($_POST['company'])))) ?: null;
        $phone = htmlspecialchars(addslashes(trim($_POST['phone']))) ?: null;
        $content = htmlspecialchars(trim($_POST['content']));

        // update message in DB
        $sql = "
            UPDATE message SET
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            company = :company,
            phone = :phone,
            content = :content
            WHERE id_message = :id
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":first_name", $firstName);
        $statement->bindParam(":last_name", $lastName);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":company", $company);
        $statement->bindParam(":phone", $phone);
        $statement->bindParam(":content", $content);
        $statement->bindParam(':id', $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../$id", "Le message a été modifié.");
    }

    // DELETE MESSAGE
    public function delete(int $id): void
    {
        $sql = "DELETE FROM message WHERE id_message = :id";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        GeneralController::redirectWithSuccess("../", "Le message a été supprimé.");
    }

    // CHECK MESSAGE FORM
    public function checkForm($redirectionPath): void
    {
        // check if required fields are filled
        if (!$_POST['last-name']) GeneralController::redirectWithError($redirectionPath, 'Le nom est obligatoire.');
        if (!$_POST['email']) GeneralController::redirectWithError($redirectionPath, 'L\'adresse email est obligatoire.');
        if (!$_POST['content']) GeneralController::redirectWithError($redirectionPath, 'Le message est obligatoire.');

        // check if visibility is set
        if ($_POST['isVisible'] !== '0' && $_POST['isVisible'] !== '1') {
            GeneralController::redirectWithError($redirectionPath, 'Erreur, veuillez réessayer.');
        }

        // check character length
        if (strlen($_POST['last-name']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le nom doit comporter entre 1 et 255 caractères.');
        }
        if (strlen($_POST['email']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email doit comporter entre 1 et 255 caractères.');
        }
        if (strlen($_POST['content']) > 1000) {
            GeneralController::redirectWithError($redirectionPath, 'Le message ne doit pas dépasser 1000 caractères.');
        }
        if (isset($_POST['first-name']) && strlen($_POST['first-name']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le prénom doit comporter entre 1 et 255 caractères.');
        }
        if (isset($_POST['company']) && strlen($_POST['company']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le nom de la société ne doit pas dépasser 255 caractères.');
        }
        if (isset($_POST['phone']) && strlen($_POST['phone']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le n° téléphone ne doit pas dépasser 255 caractères.');
        }

        // check email format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            GeneralController::redirectWithError($redirectionPath, 'Email non valide.');
        }
    }
}
