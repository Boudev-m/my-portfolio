<!-- MANAGE USERS (ADMIN UNIQUEMENT) -->
<!-- Page qui affiche toutes les compétences -->

<?php include '../assets/inc/back/head.php' ?>
<title>Gestion des Compétences</title>

<!-- Vérifie si l'utilisateur connecté est Admin -->
<?php require '../core/authentificationAdmin.php' ?>

<!-- GET ALL SKILLS FROM DB -->
<?php
require '../core/skillController.php';
$skills = readAllSkills();
?>

<?php include '../assets/inc/back/header.php' ?>

<main>
    <div class="bg-dark mb-2" style="border: 2px solid #666;">
        <h4 class="text-center pt-1">Gestion des Compétences</h4>
    </div>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    };
    ?>
    <div class="card bg-dark pb-0" style="border: 2px solid #666;">

        <table class="table table-striped table-dark table-hover text-center">

            <!-- EN-TETES DU TABLEAU -->
            <tr>
                <th class="col-1">Id</th>
                <th class="col-2">Titre</th>
                <th class="col-2">Type</th>
                <th class="col-2">Text</th>
                <th class="col-2">Image</th>
                <th class="col-2">Lien</th>
                <th class="col-2">Actif</th>
                <th class="text-center col-1">Voir</th>
                <th class="text-center col-1">Modifier</th>
                <th class="text-center col-1">Supprimer</th>
            </tr>

            <!-- AFFICHE TOUTES LES COMPETENCES -->
            <?php
            foreach ($skills as $skill) :
                $type = $skill['type'] === '1' ? '<span style="color:red;font-weight:bold;">Front-end</span>' : '<span style="color:blue;font-weight:bold;">Back-end</span>';
                $image = !empty($skill['image']) ? $skill['image'] : 'no-image.png';
                $active = $skill['active'] === '1' ? 'Activé' : 'Désactivé';
                echo "
                    <tr class='align-middle'>
                    <td>{$skill['id']}</td>
                    <td>{$skill['title']}</td>
                    <td>$type</td>
                    <td>{$skill['text']}</td>
                    <td><img src='../assets/images/upload/$image' alt='test' width=70% class='rounded'></td>
                    <td><a href='{$skill['link']}' class='link-info'>{$skill['link']}</a></td>
                    <td>$active</td>
                    <td class='text-center'><a href='./detailSkill.php?id={$skill['id']}'>
                    <div class='btn btn-success fs-5 py-1 px-2'>&#128209;</div></a></td>
                    <td class='text-center'><a href='./updateSkill.php?id={$skill['id']}'>
                    <div class='btn btn-info fs-5 py-1 px-2'>&#128394;</div></a></td>
                    <td class='text-center'><a href='./confirmDeleteSkill.php?id={$skill['id']}'>
                    <div class='btn btn-danger fs-5 py-1 px-2'>&#128465;</div></a></td>
                    </tr>";
            endforeach;
            ?>
        </table>
    </div>
</main>

<?php include '../assets/inc/back/footer.php' ?>