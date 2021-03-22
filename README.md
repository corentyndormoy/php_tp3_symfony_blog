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
Un formulaire Symfony est un formulaire (dont chaque champ est lui même un form) qui reprend les champs d'une entité.
La commande pour créer un formulaire: ```php bin/console make:form```

## Quels avantages offrent l'usage d'un formulaire ?
Les formulaires Symfony sont facilement personnalisable.

## Quelles sont les différentes personalisations de formulaire qui peuvent être faites dans Symfony ?
On peut appliquer un thème:
- à un tous les formulaires;
- à un seul formulaire;
- à plusieurs formulaires.

*Source: https://symfony.com/doc/current/form/form_themes.html*

## Définir les termes suivants : Encoder, Provider, Firewall, Access Control, Role, Voter
*Source: https://symfony.com/doc/current/security.html*
### Encoder
Encoder permet de chiffrer. C'est dans ```config/packages/security.yaml``` qu'on choisit dans quelle classe l'utiliser, et quel algorithme utiliser pour chiffrer.

*Source: https://symfony.com/doc/current/security/named_encoders.html*

### Provider
Provider permet de gérer les sessions (garder l'utilisateur authentifié).

*Source: https://symfony.com/doc/current/security/user_provider.html*

### Firewall
Le Firewall permet de restreindre l'accès à certaines informations.
Ces restrictions peuvent se faire en fonction:
- d'un chemin;
- d'un hôte;
- d'une méthode HTTP;
- d'un service.

*Source: https://symfony.com/doc/current/security/firewall_restriction.html*

### Access Control
L'access control permet de restreindre l'accès à certaines pages, notamment en fonction du rôle.
Un exemple directement dans le Twig:
```
{% if is_granted('ROLE_ADMIN') %}
    <a href="...">Delete</a>
{% endif %}
```

*Source: https://symfony.com/doc/current/security/access_control.html*
*Source: https://symfonycasts.com/screencast/symfony-security/access-control*
*Source: https://symfony.com/doc/current/security.html#access-control-in-templates*

### Role
Les rôles permettent de grouper des utilisateurs pour leur donner des droits et des restrictions (généralement pour accéder à des pages).

*Source: https://symfony.com/doc/current/security.html#roles*
*Source: https://symfony.com/doc/current/security.html#hierarchical-roles*

### Voter
Le voter permet de gérer les permissions.

*Source: https://symfony.com/doc/current/security/voters.html*

## Qu'est-ce que FOSUserBundle ? Pourquoi ne pas l'utiliser ?
FOSUserBundle est un bundle de Symfony qui premet de simplifier la gérance des utilisateurs.
On ne l'utilise pas car on peut gérer les utilisateurs et les permissions sans ce bundle (et ainsi éviter une dépendance).

*Source: https://symfony.com/doc/2.x/bundles/EasyAdminBundle/integration/fosuserbundle.html*

## Définir les termes suivants : Argon2i, Bcrypt, Plaintext, BasicHTTP
### Argon2i
Argon2 est une fonction de dérivation de clé. En d'autres termes, cela permet de crypter une chaine de caractère (mot de passe).

*Source: https://fr.wikipedia.org/wiki/Argon2"

### Bcrypt
bcrypt est une fonction de hachage. En d'autres termes, cela permet de crypter une chaine de caractère (mot de passe).

*Source: https://fr.wikipedia.org/wiki/Bcrypt*

### Plaintext
Plaintext signifie 'Text en clair'. Il est donc nécessaire de le changer par un algorithme de hachage.
Exemple, passer de:
```
# config/packages/security.yaml
security:
    # ...

    encoders:
        Symfony\Component\Security\Core\User\User: plaintext
    # ...
```
en
```
# config/packages/security.yaml
security:
    # ...

    encoders:
        Symfony\Component\Security\Core\User\User:
            algorithm: bcrypt
            cost: 12
```

*Source: https://symfony.com/doc/4.0/security.html#b-configuring-how-users-are-loaded*

### BasicHTTP
BasicHTTP permet de valider les authentifications HTTP.

*Source: https://symfony.com/doc/current/security/auth_providers.html*

## Expliquer le principe de hachage.
Le hachage, c'est le fait de rendre une chaine de caractère non reconnaissable. Elle est changée en une autre chaine de caractère.
Chiffrer un mot de passe permet d'éviter que les hébergeurs puissent lire le mot de passe en base de données.

*Source: https://fr.wikipedia.org/wiki/Fonction_de_hachage*

## Authentification
Pour créer un formulaire d'authentification, utiliser la commande suivante:
```php bin/console make:auth```

*Source: https://symfony.com/doc/current/security/form_login_setup.html*

## Faire un schema expliquant quelle méthode est appelée dans quel ordre dans le LoginFormAuthenticator . Définir l'objectif de chaque méthodes du fichier.
### 1.supports
La méthode *supports* vérifie que l'utilisateur envoie une demande d'authentification provenant de la page de login (app_login) et que la requête est bien de type POST.

### 2.getCredentials
Si la méthode *supports* retourne *false*, alors le processus d'authentification s'arrête.
En revanche, si elle retourne *true*, alors il appelle la méthode *getCredentials*.
Cette dernière retourne l'username, le mot de passe et un token.

### 3.getUser
A partir des informations récupérées depuis la fonction *getCredentials*, la méthode *getUser* permet de retourner un Utilisateur (ou *null* si n'est pas trouvé; dans ce cas, le processus d'authentification est arrêté).

### 4.checkCredentials
Si la méthode *getUser* trouve un Utilisateur, alors la méthode *checkCredentials* est appelée à son tour.
Cette dernière permet de vérifier si le mot de passe (ou d'autres informations) est correcte.
Si elle retourne *true*, alors l'utilisateur s'authentifie, sinon le processus d'authentification s'arrête.

*Source: https://symfonycasts.com/screencast/symfony-security/login-form-authenticator*

## Inscription
Pour créer un formulaire d'inscription, il faut utiliser la commande: ```php bin/console make:registration-form```

## Services
Définition des termes suivants:

### Service
Un service est une classe dans laquelle on dépose des méthodes qui permettent de retravailler nos objets.
Ce sont des méthodes qui peuvent être réutilisées partout dans le projet.
Les services permettent notamment d'arranger l'architecture de l'application.

*Source: https://symfony.com/doc/current/service_container.html*

### Dependency Injection
Une injection de dépendance, c'est-à-dire passer un object à un autre.
De ce fait, on peut avoir un service qui comprend d'autres services à sa création, et donc sont accessibles depuis ce premier.

*Source: https://symfony.com/doc/current/components/dependency_injection.html*
*Source: https://stackoverflow.com/questions/130794/what-is-dependency-injection*

### Autowiring
L'autowiring permet de passer automatiquement le bon service dans chaque méthode en lisant les informations du constructeur.

*Source: https://symfony.com/doc/current/service_container/autowiring.html*

### Container
Un Container permet de rendre un service plus flexible, en y proposant le choix des arguments.
Exemple avec une classe Mailer:
```
class Mailer
{
    private $transport;

    public function __construct($transport)
    {
        $this->transport = $transport;
    }

    // ...
}
```

On peut créer un container et y choisir le transport (sendmail):
```
use Symfony\Component\DependencyInjection\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder
    ->register('mailer', 'Mailer')
    ->addArgument('sendmail');
```

*Source: https://symfony.com/doc/current/service_container.html*
*Source: https://symfony.com/doc/current/components/dependency_injection.html*

## Validateurs
Les validateurs permettent de donner des contraintes sur des champs de formulaire.
On les écrits directement dans la classe de l'entité pour avoir une validation qui se fait dans le back.
Ainsi, on ne peut pas retirer les contraintes avec l'inspecteur.
Cela permet d'éviter que des utilisateurs entrent n'importe quoi dans la base de données.

On peut valider les données lors de la création ou la modification d'un objet.

Installation avec: ```composer require symfony/validator doctrine/annotations```

Pour ajouter une condition demandant à ce que le champ ne soit pas nul, il faut utiliser dans l'entité:
```use Symfony\Component\Validator\Constraints as Assert;```
Puis, en dessus de l'attribut choisis, ajouter la condition:
```@Assert\NotBlank```
Attention, il ne faut pas oublier de rendre nullable le mutateur du champ en ajoutant un '?'. Exemple:
```
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
```

### Champ unique
Par exemple, dans le cas d'un utilisateur, on peut souhaiter que l'username soit unique.
Pour cela, il faut utiliser dans l'entité souhaitée:
```use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;```
et renseigner en dessus de la classe:
```@UniqueEntity(fields={"username"}, message="There is already an account with this username")```

*Source: https://symfony.com/doc/current/validation.html*

## Serializer
Les différentes parties du Serializer sont:
ObjectNormalizer : utilise le composant pour accéder aux propriétés de l’objet. Cherche les propriétés public de l’objet, cherche toutes les méthodes public ayant en nom get/set/has/is/add/remove suivi d’un nom de propriété ainsi que les méthodes magiques.
GetSetMethodNormalizer : utilise les getter/setter de l’objet. Cherche toutes les méthodes public ayant en nom get suivi d’un nom de propriété.
PropertyNormalizer : utilise PHP reflexion pour accéder aux propriétés de l’objet. Cherche les propriétés public et private de l’objet.

Tout comme les normalizers, le composant Serializer inclut plusieurs encodeurs/decodeurs de format :
JsonEncoder, XmlEncoder, YamlEncoder et CsvEncoder.

*Source: https://www.novaway.fr/blog/tech/comment-utiliser-le-serializer-symfony*