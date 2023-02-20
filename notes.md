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
- front-office : 2
- back-office : 10+

## SECURITE
- DONNEES STOCKES EN SESSION
- MDP HASHé DANS LA BDD
- DROIT D'ACCES AU BACK-OFFICE UNIQUEMENT RESERVé A L'ADMIN

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
- mettre le site en MVC, avec l'utilisation des class, namespace, autoloader, PDO et la connexion unique à la BDD

- ne créer qu'une seule connexion à la BDD avec PDO (voir le projet MVC OCR)
- fonction ajout de commentaire au message
- faire apparaitre l'image après la selection d'une image à uploader (avec js ?)
- modification mdp avec ancien mdp et confirmation new mdp
- ajouter la possibilité de mettre plusieurs images pour les projects
- faire fonctionner l'envoi de mail vers ma boite (pour la page contact)
- mettre un htaccess pour réécrire les urls (je l'ai ajouté mais ne fonctionne pas)
- ajouter un champ level dans la table skill (mon niveau pour une compétence, basé sur 5 étoiles)
- optimiser les requêtes SQL : recuperer seulement les champs necessaires
- clean code, reduire le php dans le html et corriger les types (bool, null, ...), form (submit && action)
- optimiser les chemins de fichier ou utiliser un autoloader
- Dans la BDD, les champs nullables doivent être NULL si ils sont vides
- lier les skills au projet (many to many)
- ne pas afficher de lien vers la page de connexion (car sert uniquement pour la connexion admin)
- apparemment le 'no-image.png' se supprime quand j'effectue une opération (laquelle ?)
- écrire les commentaires et la doc en anglais
- afficher une icone github sur le home
- créer une classe picture pour les images
- ajouter un bouton suppression d'image et un bouton ajout d'image seulement
- voir github de Srikahn (Richard) pour le portofolio orienté objet
- utiliser le format de la date présente dans la class Project Model et le créer pour Message Model
- var env pour les identifiants de la BDD
- faire disparaitre le bouton de connexion
- ajout d'un champ hidden_password pour camoufler le mot de passe non hashé (seulement les 2 derniers caractères sont visibles)