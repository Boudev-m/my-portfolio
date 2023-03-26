<?php
// IMAGE CONTROLLER
// Contains functions for uploading images

namespace App\Controllers;

use PDO;

class ImageController
{
    // CREATE IMAGE NAME (create a name for the new uploaded image)
    public static function createName(): string
    {
        $imageName = explode(".", $_FILES['image']['name'])[0] . '_' . uniqid() . '.' . explode("/", $_FILES['image']['type'])[1];

        // if 'SVG+XML' extension
        if (strstr($imageName, "+xml")) {
            $imageName = explode("+xml", $imageName)[0];
        }

        return $imageName;
    }

    // SAVE IMAGE FILE TO DISK (in 'assets/images/upload' directory)
    public static function saveToDisk(string $imageName): void
    {
        $uploadDirectory = join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'images', 'upload']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . DIRECTORY_SEPARATOR . $imageName);
        // takes 2 args : source file path, and directory path + image name to save
    }

    // REMOVE IMAGE FILE FROM DISK
    public static function removeFromDisk(int $id, string $table): void
    {
        // get the old image name from DB
        $sql = "SELECT image FROM $table WHERE `id_$table` = :id";
        $statement = DatabaseConnection::getConnection()->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $oldImageName = $statement->fetch()->image;

        // check if the old image exist
        if (!is_null($oldImageName)) {
            $uploadDirectory = join(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'assets', 'images', 'upload']);
            unlink($uploadDirectory . DIRECTORY_SEPARATOR . $oldImageName);
        }
    }
}
