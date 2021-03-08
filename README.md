# Tp3_Blog_Symfony

## Quelles sont les fonctionnalités principales du Symfony CLI ?
Les principales fonctionnalités du Symfony CLI sont:
- La création d'un projet Symfony:
```
 symfony new --full my_project
```
- La création d'un mini projet Symfony (Microservice, console application ou API):
```
symfony new my_project
```
- L'utilisation de components:
```
composer require <components>
```
*Source: https://symfony.com/download*


### Pour changer la version de PHP que le projet utilise
Utiliser la commande pour voir les différentes versions de PHP disponibles sur la machine:
```symfony local:php:list```
Et si vous voulez lui forcer la version en un type particulier, mettez dans le dossier dans lequel vous voulez créer un fichier .php-version qui contiendra la version que vous voulez, par exemple : 
```8.0.1```

### Créé une entité
Utiliser la commande:
```make:entity``` ou ```php bin/console make:entity```

## Quelles relations existent entre les entités (Many To One/Many To Many/...) ? Faire un schéma de la base de données.
Imaginons une relation entre une table Utilisateur et une table Article:
### ManyToOne
- Chaque Article est relié à (possède) **un seul** Utilisateur.
- Chaque Utilisateur est relié à (peut avoir) **plusieurs** Articles.

### OneToMany
- Chaque Article est relié à (possède) **plusieurs** Utilisateurs.
- Chaque Utilisateur est relié à (peut avoir) **un seul** Article.

### ManyToMany
- Chaque Article est relié à (possède) **plusieurs** Utilisateurs.
- Chaque Utilisateur est relié à (peut avoir) **plusieurs** Articles.

### OneToOne
- Chaque Article est relié à (possède) **un seul** Utilisateur.
- Chaque Utilisateur est relié à (peut avoir) **un seul** Article.

*Source: https://symfony.com/doc/current/doctrine/associations.html*

## Expliquer ce qu'est le fichier .env
Le fichier .env est un fichier qui contient les variables d'environnement.
C'est notamment dans ce dernier qu'on renseigne la connexion à la base de données; et si on est dans un environnement de developpement ou de production.
Attention, le fichier .env avec les informations sensibles ne doit pas être commit.
Créé un fichier .env.local qui reprendre la syntaxe de .env, et entre les informations sensibles dans le .local.
Ce fichier est bloqué par le .gitignore.

## Expliquer pourquoi il faut changer le connecteur à la base de données
Il faut changer le connecteur de la base de données car les identidiants/mot de passe peuvent (et doivent) différer entre le travail fait en local, et le projet mis en production.

*Source: https://symfony.com/doc/current/configuration.html#config-dot-env*

## Expliquer l'intérêt des migrations d'une base de données
Les migrations permettent de faire du versionning sur la base de données.
Chaque migration est enregistrée dans un dossier "migrations", qui contient les requêtes permettant d'ajouter, modifier ou supprimer des tables ou des colonnes.

### Could not find driver
Si lors de la migration (avec la commande: ```php bin/console make:migration```), les erreurs suivantes apparaissent:
In AbstractPostgreSQLDriver.php line 102: An exception occurred in driver: could not find driver.
Alors le php.ini de la version utilisée est male configuré. Pour cela, éditer le fichier php.ini, et décommenter les lignes suivantes:
- extension=pdo_pgsql
- extension=pdo_sqlite
- extension=pgsql

*Source: https://stackoverflow.com/questions/10085039/postgresql-pdoexception-with-message-could-not-find-driver*

### Configurer notre fichier .env.local pour du SQLite
Copier le fichier .env et nommer cette copie ".env.local".
Dans .env.local, décommenter la ligne de DATABASE_URL utilisant le SQLite; et commenter les 2 autres (avec "#").
Enfin, on peut utiliser la commande ```php bin/console make:migration``` pour créer un fichier de migration (une version).
Pour lancer la migration (pour effectuer les modifications de la base de données avec les dernières versions):
```php bin/console doctrine:migrations:migrate```

## Qu'est-ce que EasyAdmin ?
EasyAdmin permet de créer des pages d'administration back-end.
Installation:
```composer require easycorp/easyadmin-bundle```

*Source: https://symfony.com/doc/current/bundles/EasyAdminBundle/index.html*

## Pourquoi doit-on implémenter des méthodes to string dans nos entités?
On doit implémenter des méthodes to string dans nos entités pour pouvoir les utiliser dans notre Dashboard.
Par exemple pour la création d'un poste et qu'on doit choisir un utilisateur, cela appelera automatiquement la méthode toString.
```
    public function __toString(): string 
    {
        return $this->username();
    }
```

### Contrôleur, bonne pratique:
Un contrôleur ne devrait pas avoir plus de 5 méthodes
Une méthode de contrôlleur ne devrait pas contenir plus de 20 lignes

#### Créer un contrôleur:
```php bin/console make:controller```
En plus de créer le contrôleur avec une méthode d'index; cela créé un petit modèle de template.

## Qu'est-ce que le ParamConverter ? À quoi sert le Doctrine Param Converter ?
Le ParamConverter permet de convertir les paramètres de la requête en objet.

*Source: https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html*

## Qu'est-ce qu'un formulaire Symfony ?
Un formulaire Symfony est un formulaire qui reprend les champs d'une entité.

## Quels avantages offrent l'usage d'un formulaire ?
Les formulaires Symfony dont facilement personnalisable.