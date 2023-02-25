<?php

if (session_status() === 1) session_start();
require_once(__DIR__ . "/databaseConnection.php");

class ImageController
{
    // FONCTION DE NOMMAGE DE L'IMAGE (nomme l'image chargé)
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

    // FONCTION DE SAUVEGARDE DE L'IMAGE SUR LE DISQUE (sauvegarde l'image dans le dossier 'upload')
    public static function saveToDisk($imageName): void
    {
        // SAUVEGARDE L'IMAGE
        // prend 2 params : chemin du fichier source et chemin + nom de sauvegarde dans le back
        $imagePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        // var_dump('Nouvelle image sauvegardée sur le disque : ' . $imageName);
    }

    // FONCTION DE SUPPRESSION D'IMAGE DU DISQUE
    public static function removeFromDisk($pdo, $id, $table): void
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
}
