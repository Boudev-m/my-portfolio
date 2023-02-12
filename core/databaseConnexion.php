<?php
// Fichier de connexion à supprimer une fois PDO complètement implémenté

// var de connexion
$online = false;

// vérifie la connexion
if (!$online) :
    $host = 'localhost';    // hebergeur de la BDD
    $user = 'root';         // user name de la BDD
    $password = '';         // mdp de la BDD
    $bdd = 'portfolio';     // nom de la bdd sql phpmyadmin
else :
    // à remplir avec les données fournis par l'hebergeur
    $host = '';         // server name
    $user = '';         // user name
    $password = '';     // password
    $bdd = '';          // data base
endif;

// mise en place de la connexion, Connecte le site à la BDD
$connexion = mysqli_connect($host, $user, $password, $bdd);

// passage des retours des requêtes au format d'encodage UTF-8
mysqli_query($connexion, "SET NAMES 'utf8'");
