<?php
// ACCOUNT CONTROLLER

namespace App\Controllers;

use PDO;
use App\Models\Account;

class AccountController
{
    // LOGIN
    function login(string $email, string $password): void
    {
        // check if form valid
        $this->checkLoginForm($_SERVER['REQUEST_URI']);

        // formatting the email
        $email = strip_tags(trim(strtolower($email)));

        // get user account (the email field has unique key in database)
        $sql = " SELECT email, password FROM account WHERE email = :email";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":email", $email);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Account::class);
        $account = $statement->fetch();

        // check if user account exist
        $account ?: GeneralController::redirectWithError($_SERVER['REQUEST_URI'], 'Aucun compte ne correspond à cette email.');

        // check user password
        password_verify(trim($password), $account->password) ?: GeneralController::redirectWithError($_SERVER['REQUEST_URI'], 'Mot de passe incorrect.');

        // login success, saving datas in session (to access back office)
        $_SESSION['isLogged'] = true;
        $_SESSION['role'] = 'admin';
        GeneralController::redirectWithSuccess('../admin/dashboard', "Vous êtes connecté.");
    }

    // LOGOUT
    function logout(): void
    {
        // remove datas in session to log out user
        session_destroy();
        session_start();
        GeneralController::redirectWithSuccess('http://localhost/portfolio', 'Vous êtes déconnecté.');
    }

    // GET ACCOUNT FROM DATABASE
    function read(): Account
    {
        // get user account
        $sql = "SELECT id_account, email, hidden_password, updated_at FROM account";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Account::class);
        $account = $statement->fetch();
        return $account;
    }

    // UPDATE ACCOUNT EMAIL
    function updateEmail(): void
    {
        // check if form valid
        $this->checkUpdateEmailForm($_SERVER['REQUEST_URI']);

        // formatting the old email
        $email = strip_tags(trim(strtolower($_POST['email'])));

        // get user account
        $sql = "SELECT * FROM account WHERE email = :email";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":email", $_POST['email']);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Account::class);

        // check if user account exist
        $statement->fetch() ?: GeneralController::redirectWithError($_SERVER['REQUEST_URI'], 'L\'email actuel ne correspond à aucun compte.');

        // formatting the new email
        $email = strip_tags(trim(strtolower($_POST["newEmail"])));

        // update user email in DB
        $sql = "UPDATE account SET email = :email, updated_at = CURRENT_TIMESTAMP()";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":email", $email);
        $statement->execute();
        GeneralController::redirectWithSuccess('./', 'L\'email a été modifié.');
    }

    // UPDATE ACCOUNT PASSWORD
    function updatePassword(): void
    {
        // require_once(__DIR__ . DIRECTORY_SEPARATOR . "GeneralController.php");
        $this->checkUpdatePasswordForm($_SERVER['REQUEST_URI']);

        // Vérifie le mdp
        $sql = "SELECT * FROM account";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Account::class);
        $account = $statement->fetch();

        // Vérifie le mdp
        password_verify(trim($_POST['password']), $account->password) ?: GeneralController::redirectWithError($_SERVER['REQUEST_URI'], 'Le mot de passe actuel est incorrect.');

        $password = strip_tags(trim($_POST['newPassword']));
        // le hiddenPassword sera affiché et servira de rappel à l'utilisateur
        $hiddenPassword = str_repeat('*', strlen($password) - 2) . substr($password, -2);
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        // Requête SQL pour modifier le mdp
        $sql = "
            UPDATE account SET
            password = :password,
            hidden_password = :hidden_password,
            updated_at = CURRENT_TIMESTAMP()
        ";

        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":hidden_password", $hiddenPassword);
        $statement->execute();

        GeneralController::redirectWithSuccess('./', 'Le mot de passe a été modifié.');
    }

    // CHECK LOGIN FORM (checking the validity of the form, takes redirection path in arg in case the form isn't valid)
    function checkLoginForm(string $redirectionPath): void
    {
        // check if required fields are filled
        if (!$_POST['email']) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email est obligatoire.');
        }
        if (!$_POST['password']) {
            GeneralController::redirectWithError($redirectionPath, 'Le mot de passe est obligatoire.');
        }

        // check character length
        if (strlen($_POST['email']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email doit comporter entre 1 et 255 caractères.');
        }
        if (strlen($_POST['password']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le mot de passe doit comporter entre 1 et 255 caractères.');
        }

        // check email format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            GeneralController::redirectWithError($redirectionPath, 'Email non valide.');
        }
    }

    // CHECK UPDATE EMAIL FORM
    function checkUpdateEmailForm(string $redirectionPath): void
    {
        // check if required fields are filled
        if (!$_POST['email']) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email est obligatoire.');
        }
        if (!$_POST['newEmail']) {
            GeneralController::redirectWithError($redirectionPath, 'Le nouvel email est obligatoire.');
        }
        if (!$_POST['newEmailConfirmation']) {
            GeneralController::redirectWithError($redirectionPath, 'La confirmation du nouvel email est obligatoire.');
        }

        // check character length
        if (strlen($_POST['email']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email doit comporter entre 1 et 255 caractères.');
        }
        if (strlen($_POST['newEmail']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le nouvel email doit comporter entre 1 et 255 caractères.');
        }

        // check email format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            GeneralController::redirectWithError($redirectionPath, 'Email non valide.');
        }
        if (!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL)) {
            GeneralController::redirectWithError($redirectionPath, 'Nouvel email non valide.');
        }

        // check comparaison between new email and confirmation email
        if ($_POST['newEmailConfirmation'] !== $_POST['newEmail']) {
            GeneralController::redirectWithError($redirectionPath, 'L\'email de confirmation doit être identique au nouvel email saisi.');
        }
    }

    // CHECK UPDATE PASSWORD FORM
    function checkUpdatePasswordForm(string $redirectionPath): void
    {
        // check if required fields are filled
        if (!$_POST['password']) {
            GeneralController::redirectWithError($redirectionPath, 'Le mot de passe actuel est obligatoire.');
        }
        if (!$_POST['newPassword']) {
            GeneralController::redirectWithError($redirectionPath, 'Le nouveau mot de passe est obligatoire.');
        }
        if (!$_POST['newPasswordConfirmation']) {
            GeneralController::redirectWithError($redirectionPath, 'La confirmation du nouveau mot de passe est obligatoire.');
        }

        // check character length
        if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le mot de passe actuel doit comporter entre 8 et 255 caractères.');
        }
        if (strlen($_POST['newPassword']) < 8 || strlen($_POST['newPassword']) > 255) {
            GeneralController::redirectWithError($redirectionPath, 'Le nouveau mot de passe doit comporter entre 8 et 255 caractères.');
        }

        // check comparaison between new password and confirmation password
        if ($_POST['newPasswordConfirmation'] !== $_POST['newPassword']) {
            GeneralController::redirectWithError($redirectionPath, 'Le mot de passe de confirmation doit être identique au nouveau mot de passe saisi.');
        }
    }
}
