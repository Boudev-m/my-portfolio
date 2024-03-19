### Portfolio
  
Objectif : créer un site qui regroupe mes réalisations, mes compétences, mon parcours, et également un système de connexion et un tableau de bord pour que je puisse gérer les données de l'application.  
Crée à partir de l'ancienne version de mon portfolio (https://github.com/boudev-m/my-portfolio-old-version)

### FONCTIONNALITES GLOBALES
- Gestion des réalisations (afficher les informations, créer, modifier, supprimer)
- Gestion des compétences (afficher les informations, créer, modifier, supprimer)
- Publier un message sur la page d'accueil
- Contacter le propriétaire de l'application en privé par mail
- Gestion des messages publics et privés (afficher, modifier, supprimer)
- Gestion du compte admin (afficher les informations du compte, modifier)
- Connexion et authentification utilisateur

### INSTALLATION
Dans un premier temps, vous devez installer Wamp (ou Xamp ou Mamp ou autre environnement contenant un serveur Apache, MySQL et PHP). Un dossier wamp/ devrait se créer à la racine du disque C:/.  
Ensuite clonez ce dépôt et placez-le dans le dossier 'www' (ou 'htdoc' selon l'environnement) qui se trouve dans le dossier wamp/.  
  
Il vous faudra générer le dossier vendor/ qui contient les dépendances du projet : placez-vous à la racine du dépôt en ligne de commande et taper la commande ```php composer.phar install```.  

Il vous faudra créer la base de donnée : lancez le serveur Wamp puis allez sur PhpMyAdmin depuis votre navigateur. Créez une nouvelle base de donnée et importez-y le script SQL database.sql. Votre BDD contiendra toutes les tables et champs nécessaires, ainsi qu'un compte Administrateur pour se connecter dans l'application et accéder au back-office.  
Les identifiants du compte sont :  
- email : ```admin@gmail.com```  
- mot de passe : ```ADMIN729```  
Vous pourrez modifier l'email et le mot de passe du compte dans la section 'Mon compte' du tableau de bord.  
  
Il vous faudra ajouter vos identifiants de base de données dans les variables d'environnement : accédez au fichier .env.example, retirez '.example' dans le nom du fichier, puis ouvrez ce fichier et mettez vos propres identifiants de BDD (nom, hôte, utilisateur et mot de passe).  
  
Une fois tout ceci accompli, allez à l'adresse http://localhost


### TECHNOS UTILISEES
```HTML - CSS - BOOTSTRAP - PHP - MYSQL```  
Programmation orienté objet avec l'utilisation des class, des namespaces et de PDO.

### SGBDR
```MYSQL```

### MODELES EN BASE DE DONNEES
- PROJECT (projet ou réalisation)
- SKILL (compétence)
- MESSAGE (message)
- ACCOUNT (compte utilisateur)

### ENVIRONNEMENT DE DEVELOPPEMENT
```Visual studio code - WAMP server```

### COMPOSITION DU PROJET
```admin/```          : contient la partie back office  
```assets/```         : contient les composants (head/header/footer), images, styles, js, etc...  
```src/```            : contient les controllers et modèles  
```vendor/```         : contient les dépendances du projet et l'autoloader  
```index.php```       : page d'accueil (front office)  
```contact.php```     : page de contact (front office)  
```.htaccess```       : fichier de config Apache  
```.env.example```    : exemplaire du fichier .env (sans les données sensibles)  
```composer.json```   : infos sur le projet  
```composer.lock```   : infos sur la version des dépendances du projet  
```composer.phar```   : l'executable de composer
```database.sql```    : script de création de la BDD
  
Pour des raisons de sécurité, le fichier .env d'origine n'est pas disponible.

### COMPOSER
Composer a été installé dans ce projet pour permettre le chargement automatique des classes avec l'autoloader et l'installation de certaines dépendances : 
- ``vlucas/phpdotenv`` : pour l'exploitation des variables d'environnements
- ``google/recaptcha`` : pour éviter les spams et abus dans les formulaires

### PAGES / URLs DE L'APPLICATION
``/``                               : page d'accueil  
``/contact``                            : page de contact  

``/admin``                              : page de connexion (pour l'authentification admin)  
``/admin/dashboard``                    : tableau de bord  
``/admin/account``                      : details du compte admin  
``/admin/account/update-email``         : modifier l'email du compte  
``/admin/account/update-password``      : modifier le mdp du compte  

``/admin/project``                      : liste des projets  
``/admin/project/new``                  : créer un projet  
``/admin/project/{id}``                 : détails d'un projet  
``/admin/project/{id}/update``          : modifier un projet  
``/admin/project/{id}/confirm-delete``  : confirmer la suppression d'un projet  

``/admin/skill``                        : liste des compétences  
``/admin/skill/new``                    : créer une compétence  
``/admin/skill/{id}``                   : détails d'une compétence  
``/admin/skill/{id}/update``            : modifier une compétence  
``/admin/skill/{id}/confirm-delete``    : confirmer la suppression d'une compétence  

``/admin/message``                      : liste des messages  
``/admin/message/{id}``                 : détails d'un message  
``/admin/message/{id}/update``          : modifier un message  
``/admin/message/{id}/confirm-delete``  : confirmer la suppression d'un message  

### SECURITE
Pour éviter les failles de sécurité et renforcer le site, les méthodes ci-dessous ont été appliqués :
- Données de login stockés temporairement en session
- Authentification requise pour l'accès au back office (en analysant les données en session) et pour chaque action importante
- Mot de passe du compte haché : la vérification se fait pendant le loggin en comparant l'origine du mdp haché avec le mdp saisi par l'utilisateur
- Utilisation de la fonction 'htmlspecialchar' avant l'enregistrement des données pour contrer les failles XSS
- Vérification des formulaires avant validation ('Never Trust User Input')
- Utilisation des paramètres nommés (PDO Bind param) dans les requêtes SQL pour contrer les injections malveillantes
- Utilisation des variables d'environement pour les données de configuration sensibles
- Certificat SSL installé pour crypter les données qui transitent entre le site web et le navigateur

### AXES D'AMELIORATION
- Ajouter le champ 'level' dans la table 'skill' (pour indiquer le niveau d'une compétence, basé sur une échelle de 5 par exemple)
- Afficher les messages d'alerte sous forme de fenêtre qui apparait et disparait 
- Faire apparaitre l'image après la selection d'une image à uploader (en utilisant javascript côté front)
- Ajouter la possibilité de mettre plusieurs images pour un projet (une seule image actuellement)