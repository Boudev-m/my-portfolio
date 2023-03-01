<?php
// MANAGE MESSAGE
namespace App\Controllers;

use PDO;
use App\Models\Message;
use App\Controllers\DatabaseConnection;

if (session_status() === 1) session_start();

class MessageController
{
    public function readAll(): array
    {
        $sql = "SELECT * FROM message";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, Message::class);
        return $result;
    }

    public function readOne($id): Message
    {
        $sql = "SELECT * FROM message WHERE id_message = :id";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Message::class);
        $result = $statement->fetch();
        return $result;
    }

    public function create(): void
    {
        // Récupère les fonctions générales
        // require_once 'GeneralController.php';

        // Permet d'afficher le message dans la section message
        $_SESSION['messageSection'] = true;

        // Vérifie les données du formulaire
        $this->checkForm($_POST['path']);

        // On récupère toutes les données du formulaire
        $firstName = htmlspecialchars(addslashes(trim(ucfirst($_POST['first-name']))));
        $lastName = htmlspecialchars(addslashes(trim(ucfirst($_POST['last-name']))));
        $email = htmlspecialchars(trim(strtolower($_POST['email'])));
        $company = htmlspecialchars(addslashes(trim(ucfirst($_POST['company'])))) ?: null;
        $phone = htmlspecialchars(addslashes(trim($_POST['phone']))) ?: null;
        $content = htmlspecialchars(trim($_POST['content']));

        $sql = "
            INSERT INTO message (first_name, last_name, email, company, phone, content, created_at)
            VALUES (:first_name, :last_name, :email, :company, :phone, :content, NOW())
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":first_name", $firstName);
        $statement->bindParam(":last_name", $lastName);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":company", $company);
        $statement->bindParam(":phone", $phone);
        $statement->bindParam(":content", $content);
        $statement->execute();

        GeneralController::redirectWithSuccess($_POST['path'], 'Votre message a été ajouté.');
    }

    public function update($id): void
    {
        // Récupère les fonctions générales
        // require_once 'GeneralController.php';

        // Vérifie les données du formulaire
        $this->checkForm($_SERVER['REQUEST_URI']);

        // On récupère toutes les données du formulaire
        $firstName = htmlspecialchars(addslashes(trim(ucfirst($_POST['first-name']))));
        $lastName = htmlspecialchars(addslashes(trim(ucfirst($_POST['last-name']))));
        $email = htmlspecialchars(trim(strtolower($_POST['email'])));
        $company = htmlspecialchars(addslashes(trim(ucfirst($_POST['company'])))) ?: null;
        $phone = htmlspecialchars(addslashes(trim($_POST['phone']))) ?: null;
        $content = htmlspecialchars(trim($_POST['content']));

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

    public function delete($id): void
    {
        // require_once 'GeneralController.php';
        $sql = "
        DELETE FROM message
        WHERE id_message = :id
        ";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        GeneralController::redirectWithSuccess("../", "Le message a été supprimé.");
    }

    public function checkForm($redirectionPath): void
    {
        // Vérifie si les champs obligatoires sont remplis
        if (!$_POST['last-name']) GeneralController::redirectWithError($redirectionPath, 'Le nom est obligatoire.');
        if (!$_POST['first-name']) GeneralController::redirectWithError($redirectionPath, 'Le prénom est obligatoire.');
        if (!$_POST['email']) GeneralController::redirectWithError($redirectionPath, 'L\'adresse email est obligatoire.');
        if (!$_POST['content']) GeneralController::redirectWithError($redirectionPath, 'Le message est obligatoire.');

        // Vérifie le format d'écriture de l'email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            GeneralController::redirectWithError($redirectionPath, 'Email non valide');
        }

        // Vérifie la longueur des caractères saisies
        if (strlen($_POST['last-name']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le nom doit comporter entre 1 et 255 caractères');
        }
        if (strlen($_POST['first-name']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le prénom doit comporter entre 1 et 255 caractères');
        }
        if (strlen($_POST['email']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email doit comporter entre 1 et 255 caractères');
        }
        if (strlen($_POST['content']) > 1000) {
            GeneralController::redirectWithError($redirectionPath, 'Le message ne doit pas dépasser 1000 caractères.');
        }
        if ($_POST['phone'] && strlen($_POST['phone']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le n° téléphone ne doit pas dépasser 255 caractères.');
        }
    }
}
