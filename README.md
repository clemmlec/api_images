
![GitHub top language](https://img.shields.io/github/languages/top/clemmlec/api_images)
![GitHub language count](https://img.shields.io/github/languages/count/clemmlec/api_images)
Prérequi 

  - PHP Version 8.1 Installé en local
  - MySQL Installé en local
  - Installer Composer
  - Installer Yarn
  
 Installation
 
  Après avoir cloné le projet éxécutez les commandes suivante dans un terminal à la racine du dossier : 

    - __composer install__  ( installer les dépendances composer du projet )

    - __yarn install__      ( installer les dépendances yarn du projet )

  Ensuite installer la base de donnée MySQL et paramétrer la création de votre base de donné :
    - dans le fichier .env du projet modifier la variable d'environnement selon vos paramètres :
      __DATABASE_URL="mysql://root:root@127.0.0.1:3307/api_images?serverVersion=5.7&charset=utf8mb4"__

  Puis créer de la base de donnée avec la commande : 
    __php bin/console doctrine:database:create__

  Exécuter la migration en base de donnée : 
    __php bin/console make:migration__
    __php bin/console doctrine:migration:migrate__

Pour lancer le server local :
  __symfony server:start__
  
  
