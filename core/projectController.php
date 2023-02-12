<?php
// Ce fichier permet de récupérer, créer, modifier et supprimer un projet/une réalisation

if (session_status() === 1) session_start();

require_once(__DIR__ . "/pdoConnexion.php");
require_once(__DIR__ . "/../models/Project.php");
// require_once(__DIR__ . "/../models/pictureModel.php");
// require_once(__DIR__ . "/../models/skillModel.php");

class ProjectController
{

    public function getAll(string $statut = null): array
    {
        global $pdo;

        if ($statut === 'active') {
            $sql = "SELECT * FROM project WHERE `active` = 1";
        } else {
            $sql = "SELECT * FROM project";
        }

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "Project");

        // foreach ($result as $project) {
        //     $this->loadSkillsFromProject($project);
        // }

        return $result;
    }

    public function getOne($id): Project
    {
        global $pdo;

        // Requête de récupération du projet
        $sql = "SELECT * FROM project WHERE id_project = :id";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, "Project");
        $result = $statement->fetch();

        // Requête de récupération des images
        // $sql = "SELECT * FROM picture WHERE id_project = :id";

        // $statement = $pdo->prepare($sql);
        // $statement->bindParam(":id", $id);
        // $statement->execute();

        // $result->pictures = $statement->fetchAll(PDO::FETCH_CLASS, "Pictur");

        // Requête de récupération des compétences (skills)
        // $this->loadSkillsFromProject($result);

        return $result;
    }

    // RECUPERE LES SKILLS LIéS AU PROJET
    // public function loadSkillsFromProject(ProjectModel $project)
    // {
    //     global $pdo;

    //     $sql = "SELECT 
    //         skill.id_skill, skill.name, skill.level, skill.picture
    //         FROM skill
    //         INNER JOIN skill_project ON skill_project.id_skill = skill.id_skill
    //         INNER JOIN project ON project.id_project = skill_project.id_project
    //         WHERE project.id_project = :id
    //     ";

    //     $statement = $pdo->prepare($sql);
    //     $statement->bindParam(":id", $project->id_project, PDO::PARAM_INT);
    //     $statement->execute();

    //     $project->skills = $statement->fetchAll(PDO::FETCH_CLASS, "SkillModel");
    // }
}
