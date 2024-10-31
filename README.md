# ReadMe – Lucile Monti WebSite

Le site « Lucile Monti – Cavalière Enseignante Indépendante » est un site commercial ayant pour vocation de mettre en avant le travail d’une professionnelle du monde de l’équitation. Le site est composé d’une partie « visiteurs », présentant la professionnelle et son activité, et d’une partie « compte personnel », où les clients peuvent entrer les informations concernant eux-même et leurs animaux.

Ce site a pour fonctionnalité de présenter une vitrine des activités de la professionnelle avec la possibilité de la contacter directement et rapidement, ainsi que lui permettre de gérer ses utilisateurs et réunir les informations pertinentes au suivi d’un client.

## 1. Installation et Prérequis

Afin d’installer le projet en local, il convient de suivre les étapes suivantes :

### PREMIÈRE FOIS SUR UN PC sur lequel on n'a jamais fait de Symfony :
- **Installer GitHub**  
    [https://git-scm.com/downloads](https://git-scm.com/downloads)  
    ```bash
    git config --global user.name "nom prenom"
    git config --global user.email "email"
    ```

- **Installer NodeJS**  
    [https://nodejs.org/en/download/package-manager/current](https://nodejs.org/en/download/package-manager/current)

- **Installer Yarn**  
    ```bash
    npm install -g yarn
    ```

- **Installer la version 8 de PHP**  
    - Télécharger le dossier zip depuis le site de PHP, l'extraire à la racine de votre environnement (dossier `C:\`) dans un dossier nommé `php`.
    - Configurer le `php.ini` : dans le nouveau dossier `php` créé, dupliquer le fichier `C:\php\php.ini-development` et renommer en `C:\php\php.ini`.
    - Dans `php.ini` : chercher les lignes `Dynamic Extensions`, décommenter certaines lignes pour ajouter les extensions utiles ; chercher ces lignes et enlever le `;` :
        ```ini
        extension=curl
        extension=fileinfo
        extension=gd
        extension=intl
        extension=mbstring
        extension=openssl
        extension=pdo_mysql
        extension=zip
        ; (optionnel) extension=opcache
        ```
    - Ajouter `php` dans vos variables d'environnement système :
        - Chercher dans la barre de recherche Windows "Modifier les variables d'environnement systèmes".
        - Ouvrir la page, cliquer sur le bouton "Variables d'environnement".
        - Trouver la section "Variables système", cliquer sur la ligne qui commence par `Path` et ensuite sur le bouton Modifier.
        - Cliquer sur le bouton nouveau et ajouter la ligne `C:\php`.

- **Installer Composer**  
    Voir documentation Composer [https://getcomposer.org/download/](https://getcomposer.org/download/)

- **Installer Symfony CLI**  
    Dans un terminal PowerShell NON ADMIN :
    ```powershell
    Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
    irm get.scoop.sh | iex
    scoop install symfony-cli
    ```

- **Lancer un nouveau projet Symfony**  
    Dans un terminal :
    ```bash
    symfony check:requirements
    symfony new my_project_directory --version="7.*" --webapp
    composer require --dev phpstan/phpstan
    composer install
    ```

- **Installer Webpack Encore**  
    ```bash
    composer remove symfony/ux-turbo symfony/asset-mapper symfony/stimulus-bundle
    composer require symfony/webpack-encore-bundle symfony/ux-turbo symfony/stimulus-bundle
    npm install ou yarn install
    ```

- **Configurer la connexion à la BDD**  
    Créer un fichier `.env.local` dans lequel stocker les variables d'environnement de développement :
    ```env
    DATABASE_URL="mysql://root:root@127.0.0.1:3307/NomAppli?serverVersion=8.0.32&charset=utf8mb4"
    ```

- **Créer la BDD**  
    Dans un terminal :
    ```bash
    composer dump-env dev
    symfony console doctrine:database:create
    ```

### SUR UN PC sur lequel on a fait un projet Symfony :
- Reprendre à partir d'installer Symfony CLI en utilisant les mêmes commandes avec `update` à la place d'`install` sur cette étape-là.

### Optionnel :
- **Installer Bootstrap**  
    ```bash
    npm install bootstrap@3
    npm install @popperjs/core
    ```

- **Installer SASS**  
    ```bash
    npm install -d sass
    ```
    Pour configurer SASS :
    - Dans le fichier `webpack.config.js`, décommenter la ligne :
        ```javascript
        .enableSassLoader()
        ```
    - Lancer `yarn watch`.

- **Installer des fixtures**  
    ```bash
    composer require --dev orm-fixtures
    symfony console doctrine:fixtures:load
    ```

- **Bundles pour timestamp et slug**  
    ```bash
    composer require stof/doctrine-extensions-bundle
    ```

- **Intégrer des images**  
    ```bash
    composer require vich/uploader-bundle
    ```
    Dans le fichier `config/packages/vich_uploader.yaml` : décommenter / renommer si besoin. Configurer les tables affectées :
    ```php
    use Vich\UploaderBundle\Mapping\Annotation as Vich;
    #[Vich\Uploadable]
    ```
    Faire les migrations, ajouter le champ dans le formulaire, modifier la vue.

## 2. Configuration de la base de données

La base de données est gérée avec Doctrine ORM, en utilisant l’extension DatabaseClient pour faciliter les connexions et les manipulations. Doctrine permet une gestion efficace et sécurisée des données grâce à son intégration avec Symfony, assurant ainsi une base de données évolutive et adaptable.

## 3. Utilisation

### Création d’un compte utilisateur
Les utilisateurs peuvent s’inscrire directement sur le site en fournissant leur adresse e-mail et en choisissant un mot de passe. Le mot de passe est sécurisé par un hashage automatique via les outils de sécurité intégrés de Symfony, garantissant la protection des informations d’identification.

### Gestion des profils clients et chevaux
- **Gestion des informations client** : Chaque utilisateur, une fois connecté, peut accéder à son espace personnel pour gérer ses informations personnelles, telles que son nom, ses coordonnées, et son profil.
- **Création et gestion des fiches de chevaux** : Les utilisateurs peuvent également créer et modifier des fiches pour leurs propres chevaux, incluant des informations comme le nom, la race, le sexe, et la date de naissance. De son côté, l'administratrice a accès à toutes les fiches, ce qui lui permet de gérer l'ensemble des chevaux enregistrés dans le système.

### Sécurisation des actions de suppression
Pour protéger les données, la suppression d’un compte utilisateur ou d’une fiche de cheval est sécurisée par un token CSRF (Cross-Site Request Forgery), empêchant toute suppression non autorisée et garantissant l’intégrité des informations.

## 4. Architecture du projet

## 5. Sécurité

La sécurité de l'application est une priorité, et plusieurs mécanismes sont en place pour protéger les données et les interactions des utilisateurs. Symfony gère ces mesures de sécurité de manière robuste, permettant ainsi de se conformer aux standards de protection des applications web.

- **Protection CSRF (Cross-Site Request Forgery)** : Toutes les actions sensibles, comme la suppression de comptes ou de fiches de chevaux, sont sécurisées par un token CSRF. Ce token garantit que seules les requêtes autorisées par l’utilisateur peuvent effectuer ces actions, bloquant toute tentative de requêtes malveillantes depuis des sites tiers.
- **Gestion des sessions utilisateur** : Symfony assure une gestion sécurisée des sessions en générant des identifiants de session uniques et en sécurisant les données de session pour chaque utilisateur connecté. Cela prévient les usurpations de session et renforce la protection des données personnelles.
- **Hashage des mots de passe** : Les mots de passe utilisateurs sont automatiquement hashés avec des algorithmes modernes lors de leur enregistrement, assurant ainsi qu'ils ne sont jamais stockés en clair. Ce mécanisme rend le stockage des mots de passe beaucoup plus sûr, même en cas de compromission de la base de données.

Symfony fournit un ensemble de fonctionnalités et de configurations de sécurité personnalisables, ce qui permet de renforcer ces protections en fonction des besoins de l'application, garantissant ainsi une expérience utilisateur sûre et conforme aux réglementations en vigueur.

## 6. Contributeurs et contact

Contact de la développeuse :  
GitHub : [https://github.com/ArinaMMa](https://github.com/ArinaMMa)  
LinkedIn : [https://www.linkedin.com/in/arina-mancini-marlot-5b23b1a9/](https://www.linkedin.com/in/arina-mancini-marlot-5b23b1a9/)


































































































































































