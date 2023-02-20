<?php

if (session_status() === 1) session_start();
require_once(__DIR__ . "/databaseConnection.php");

class GeneralController
{
    // FONCTION REDIRECTION AVEC SUCCES (redirige l'utilisateur avec un message de succès)
    public static function redirectWithSuccess($path, $message)
    {
        $_SESSION['message'] = "<p class='alert alert-success fs-5 text-center p-1'>$message</p>";
        exit(header("Location: $path"));
    }

    // FONCTION REDIRECTION AVEC ERREUR (redirige l'utilisateur avec un message d'erreur)
    public static function redirectWithError($path, $error)
    {
        $_SESSION['message'] = "<p class='alert alert-danger fs-5 text-center p-1'>$error</p>";
        exit(header("Location: $path"));
    }

    // FUNCTION COUNT ALL DATAS (quand on compte le nombre total de lignes dans une table)
    public static function countAllDatas(string $table): int
    {
        global $pdo;
        $table = trim($table);
        $sql = "
            SELECT * FROM $table
        ";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->rowCount();
    }

    // FONCTION CAPTURE L'ERREUR SQL (quand la BDD retourne une erreur)
    public static function catchSqlError($connexion, $redirectionPath)
    {
        // Vérifie si l'erreur est liée au duplicata de l'adresse email (clé unique)
        if (mysqli_errno($connexion) === 1062 && strpos(mysqli_error($connexion), 'email')) {
            redirectWithError($redirectionPath, 'Adresse email déjà utilisée.');
        } else {
            exit(mysqli_error($connexion));
        }
    }

    // FONCTION DE NOMMAGE DE L'IMAGE (nomme l'image chargé)
    public static function createImageName()
    {
        // NOUVEAU NOM DE L'IMAGE
        $imageName = explode(".", $_FILES['image']['name'])[0] . '_' . uniqid() . '.' . explode("/", $_FILES['image']['type'])[1];

        // SI EXTENSION 'SVG+XML'
        if (strstr($imageName, "+xml")) {
            $imageName = explode("+xml", $imageName)[0];
        }

        // RETOURNE LE NOUVEAU NOM DE L'IMAGE
        return $imageName;
    }

    // FONCTION DE SAUVEGARDE DE L'IMAGE SUR LE DISQUE (sauvegarde l'image dans le dossier 'upload')
    public static function saveImageToDisk($imageName)
    {
        // SAUVEGARDE L'IMAGE
        // prend 2 params : chemin du fichier source et chemin + nom de sauvegarde dans le back
        $imagePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        // var_dump('Nouvelle image sauvegardée sur le disque : ' . $imageName);
    }

    // FONCTION DE SUPPRESSION D'IMAGE DU DISQUE
    public static function removeImageFromDisk($pdo, $id, $table): void
    {
        // Récupère le nom de l'ancienne image dans la BDD (null ou non)
        $sql = "
            SELECT image FROM $table WHERE `id_$table` = :id
        ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $oldImageName = $statement->fetch()->image;
        // Vérifie si la compétence possède déjà une image (non null)
        if (!is_null($oldImageName)) {
            // Supprime l'ancienne
            unlink(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $oldImageName);
            // var_dump('Ancienne image supprimée du disque : ' . $oldImageName);
        } else {
            // var_dump('Cette compétence ne possèdait pas d\'image...');
        }
    }

    // TRIE UN TABLEAU
    public static function sortById($a, $b)
    {
        if ($a == $b) return 0;
        return ($a < $b) ? -1 : 1;
    }
}
