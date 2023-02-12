<?php
// Ce fichier permet de récupérer, créer, modifier et supprimer un message

if (session_status() === 1) session_start();

require_once(__DIR__ . "/pdoConnexion.php");
require_once(__DIR__ . "/../models/Message.php");

class MessageController
{

    public function getAll(): array
    {
        global $pdo;

        $sql = "SELECT * FROM message";

        $statement = $pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Message");

        return $result;
    }
}
