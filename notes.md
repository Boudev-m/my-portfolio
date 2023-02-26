## PROJET : PORTFOLIO
Site qui regroupe mes réalisations, mes compétences, mon parcours, et également un système de connexion et un tableau de bord pour que l'admin puisse gérer le site

## MODELS
PROJECT - SKILL - MESSAGE - USER (inutile de faire plusieurs users, 1 seul compte admin suffit)

## DATABASE
MYSQL

## TECHNOS
HTML - CSS - BOOTSTRAP - PHP - SQL

## ENVIRONNEMENT
VSC - WAMP

## PAGES
- front-office : 2 + page de connexion
- back-office : 10+

## ROUTES

/ (home)
/contact

/admin
/admin/dashboard
/admin/account/update-email
/admin/account/update-password

/admin/project
/admin/project/new
/admin/project/{id}
/admin/project/{id}/update
/admin/project/{id}/confirm-delete

/admin/skill
/admin/skill/new
/admin/skill/{id}
/admin/skill/{id}/update
/admin/skill/{id}/confirm-delete

/admin/message
/admin/message/{id}
/admin/message/{id}/update
/admin/message/{id}/confirm-delete

## SECURITE
- DONNEES STOCKES EN SESSION
- MDP HASHé DANS LA BDD
- DROIT D'ACCES AU BACK-OFFICE UNIQUEMENT RESERVé A L'ADMIN
(-VERIFICATION FORM)
(-BIND PARAM)
(-VAR ENV)

## IDENTIFIANTS ADMIN
- email : admin@gmail.com
- mdp : azertyuiop

- table user avec les champs :
    - id (Auto Increment, primary key)      : non null
    - last_name (VARCHAR 255)               : non null
    - first_name (VARCHAR 255)              : non null
    - email (VARCHAR 255, unique key)       : non null
    - password (VARCHAR 255)                : non null
    - role (INT 2) (1:Admin, 2:Utilisateur) : non null

- table message :
    - id (Auto Increment, primary key)      : non null
    - last_name (VARCHAR 255)               : non null
    - first_name (VARCHAR 255)              : non null
    - company (VARCHAR 255)                 : null
    - email (VARCHAR 255, unique key)       : non null
    - phone (VARCHAR 255)                   : null
    - message/description (VARCHAR 255)     : non null

- table skill :
    - id (Auto Increment, primary key)      : non null
    - title (VARCHAR 255)                   : non null
    - type (INT 2) (1:front-end, 2:back-end): non null
    - text (VARCHAR 255)                    : null
    - image (VARCHAR 255)                   : null
    - link (VARCHAR 255)                    : null
    - active (Boolean)                      : non null

Création de l'architecture (arborescence des dossiers et fichiers)
Création de la table user dans la bdd portfolio
Création du fichier help/createAdmin.php (qui va permettre de créer un Admin)
L'Admin (ou webmaster) aura accès au back-office (tableau de bord ou paneau d'administration) pour gérer le site.
Création d'une barre de nav dans inc/front/headerFront.php
Création du formulaire dans admin/index.php pour se logger et accéder au back-office
Création du fichier core/userController.php pour executer la fonction login de l'user

____________________________________

## A FAIRE
- mettre le site en MVC (x PDO, x class, namespace, autoloader)
- optimiser les chemins de fichier ou utiliser un autoloader
- connexion unique BDD (voir le projet MVC OCR)
- var env pour les identifiants de la BDD
- fonction ajout de commentaire au message
- afficher le message d'alerte sous forme de popup
- faire apparaitre l'image après la selection d'une image à uploader (avec js ?)
- ajouter la possibilité de mettre plusieurs images pour les projets
- faire fonctionner l'envoi de mail vers ma boite (pour la page contact)
- ajouter un champ level dans la table skill (mon niveau pour une compétence, basé sur 5 étoiles)
- optimiser les requêtes SQL : recuperer seulement les champs necessaires
- lier les skills aux projets (many to many), ajouter le choix multiple des compétences à la création/modification d'un projet (voir le projet de richard, le formulaire devra retourner un tableau d'ids)
- écrire les commentaires et la doc en anglais
- ajouter un bouton suppression d'image et un bouton ajout d'image seulement
- ajout champ update_date dans account (pour afficher la date de la dernière modification)
x mettre un htaccess pour réécrire les urls (clean url)
x modification mdp avec ancien mdp et confirmation new mdp
x clean code : reduire le php dans le html et corriger les types de variables (bool, null, ...), la soumission des form (submit && action)
x Dans la BDD, les champs nullables doivent être NULL si ils sont vides
x le chargement et la sauvegarde d'une nouvelle image supprime l'ancienne image du disque
x ne pas afficher de lien vers la page de connexion (car sert uniquement pour la connexion admin) path: portfolio/admin
x ajout de nouvelles methodes pour les modeles
x afficher une icone github sur le home
x créer une classe imageController pour les images
x ajout d'un champ hidden_password pour camoufler le mot de passe non hashé (seulement les 2 derniers caractères sont visibles)