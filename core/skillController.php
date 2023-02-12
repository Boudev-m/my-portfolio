<?php
// Ce fichier permet de récupérer, créer, modifier et supprimer un projet/une réalisation

if (session_status() === 1) session_start();

require_once(__DIR__ . "/pdoConnexion.php");
require_once(__DIR__ . "/../models/Skill.php");
// require_once(__DIR__ . "/../models/pictureModel.php");
// require_once(__DIR__ . "/../models/skillModel.php");

class SkillController
{

    public function getAll(string $statut = null): array
    {
        // Database connection
        global $pdo;

        // Récupère seulement les compétences actives
        if ($statut === 'active') {
            $sql = "SELECT * FROM skill WHERE `active` = 1";
        } else {
            $sql = "SELECT * FROM skill";
        }

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Skill");

        return $result;
    }

    public function getOne($id): Skill
    {
        global $pdo;

        // Requête de récupération du projet
        $sql = "SELECT * FROM skill WHERE id_skill = :id";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, "Skill");
        $result = $statement->fetch();

        return $result;
    }
}
