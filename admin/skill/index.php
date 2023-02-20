<!-- INDEX SKILLS (ADMIN UNIQUEMENT) -->
<!-- Page qui affiche toutes les compétences -->

<?php include '../../assets/inc/back/head.php' ?>
<title>Gestion des Compétences</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../../core/authentification.php' ?>

<!-- GET ALL SKILLS FROM DB -->
<?php
require '../../core/skillController.php';
$skills = (new SkillController())->readAll();
?>

<?php include '../../assets/inc/back/header.php' ?>

<main>
    <div class="mb-2" style="border: 2px solid #666;">
        <a href="http://localhost/portfolio/admin/skill/createSkill.php">
            <img src="../../assets/images/icons/add-button.svg" alt="ajouter un nouvel élément" title='Ajouter une réalisation' width=3% style='border-radius:50%;position:fixed; left:17vh;'>
        </a>
        <h4 class="text-center pt-1">Gestion des Compétences</h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="pb-0" style="border: 2px solid #666;">

        <table class="table table-striped table-hover text-center">

            <!-- EN-TETES DU TABLEAU -->
            <tr>
                <th class="col-1">Id</th>
                <th class="col-1">Image</th>
                <th class="col-2">Titre</th>
                <th class="col-2">Type</th>
                <th class="col-3">Description</th>
                <th class="col-2">Statut</th>
                <th class="text-center col-1">Voir</th>
                <th class="text-center col-1">Modifier</th>
                <th class="text-center col-1">Supprimer</th>
            </tr>

            <!-- AFFICHE TOUTES LES COMPETENCES -->
            <?php
            foreach ($skills as $skill) :
                $type = $skill->type === 1 ? '<span style="color:red;font-weight:bold;">Front-end</span>' : '<span style="color:blue;font-weight:bold;">Back-end</span>';
                $text = !empty($skill->text) ? $skill->text : '&#8211';
                $image = !empty($skill->image) ? $skill->image : 'no-image.png';
                $active = $skill->active ? 'Activé' : 'Désactivé';
                echo "
                    <tr class='align-middle'>
                    <td>{$skill->id_skill}</td>
                    <td><img src='../../assets/images/upload/$image' alt='image de la competence' width=70% class='rounded'></td>
                    <td class='text-break'>{$skill->title}</td>
                    <td>$type</td>
                    <td class='text-break'>$text</td>
                    <td>$active</td>
                    <td class='text-center'><a href='./detailSkill.php?id={$skill->id_skill}' title='Voir'>
                    <div class='btn btn-success fs-5 py-1 px-2 border border-dark'>&#128209;</div></a></td>
                    <td class='text-center'><a href='./updateSkill.php?id={$skill->id_skill}' title='Modifier'>
                    <div class='btn btn-info fs-5 py-1 px-2 border border-dark'>&#128394;</div></a></td>
                    <td class='text-center'><a href='./confirmDeleteSkill.php?id={$skill->id_skill}' title='Supprimer'>
                    <div class='btn btn-danger fs-5 py-1 px-2 border border-dark'>&#128465;</div></a></td>
                    </tr>";
            endforeach;
            ?>
        </table>
    </div>
</main>

<?php include '../../assets/inc/back/footer.php' ?>