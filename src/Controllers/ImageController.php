<?php
// IMAGE CONTROLLER

namespace App\Controllers;

use PDO;

// if (session_status() === 1) session_start();

class ImageController
{
    // FONCTION DE NOMMAGE DE L'IMAGE (créer un nom pour la nouvelle image chargée)
    public static function createName(): string
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

    // FONCTION SAUVEGARDE DE L'IMAGE SUR LE DISQUE (dossier 'upload')
    public static function saveToDisk($imageName): void
    {
        $uploadDirectory = join(DIRECTORY_SEPARATOR, [dirname(dirname(__DIR__)), 'assets', 'images', 'upload']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . DIRECTORY_SEPARATOR . $imageName);
        // Prend 2 args : chemin du fichier source, et chemin + nom de l'image à sauvegarder
    }

    // FONCTION SUPPRESSION DE L'IMAGE DU DISQUE
    public static function removeFromDisk($id, $table): void
    {
        // Récupère le nom de l'ancienne image dans la BDD (null ou non)
        $sql = "
            SELECT image FROM $table WHERE `id_$table` = :id
        ";
        $statement = (new DatabaseConnection)->getConnection()->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $oldImageName = $statement->fetch()->image;
        // Vérifie si la compétence ou le projet possède déjà une image (non null)
        if (!is_null($oldImageName)) {
            $uploadDirectory = join(DIRECTORY_SEPARATOR, [dirname(dirname(__DIR__)), 'assets', 'images', 'upload']);
            unlink($uploadDirectory . DIRECTORY_SEPARATOR . $oldImageName);
        }
    }
}
