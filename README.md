DoleticREST
=========

Ce projet est une refactorisation complète du backend de Doletic sous la forme d'une API REST sécurisée et maintenable. A terme, cette API remplacera totalement le backend de Doletic. Cette API fonctionne conjointement avec un front-end Angular4

## Comment utiliser l'API
### Installation du projet :

1. Installer [xampp](https://www.apachefriends.org/fr/index.html) ou [wamp](http://www.wampserver.com/) avec php 7.1.XXX

2. Créer une base de données doleticrest en utf8-general-ci sur phpmyadmin ou autre gestionnaire de base de données.

3. Dans le php.ini situé à `C:\xampp\php\php.ini` si vous utilisez xammp. Modifiez la variable `upload_max_filesize` à 5M.

4. Remplir la base de données doleticrest avec le fichier `doleticrest.sql` situé à la racine du projet.

5. [Forker](https://guides.github.com/activities/forking/) le repo Git DoleticRest

6. Cloner son fork localement

7. Installer [composer](https://getcomposer.org/) sur son PC.

8. Effectuer `composer install` à la racine du projet.
	* **Si pas d’extension php.7.1-xml, l’installer**
	* database_host : adresse du serveur de dev, par défaut localhost ou 127.0.0.1
	* database_port : port d’écoute du serveur mysql, par défaut 3306
	* database_name : doleticrest
	* database_user : user tel que configuré, par défaut root
	* database_password : password tel que configuré, par défaut test
	* les autres champs, appuyer sur entrer

9. Créez un client avec la commande `php app/console oauth:client:create <nom du client> <adresse de redirection> password`, récupérez le secret qui doit être inséré dans DoleticRest/app/config/parameters.yml. Récupérer également le public id qui sera utilisé par le front.

## Utilisation du server

Lancez le serveur back-end avec la commande  `php app/console server:run` votre serveur écoute maintenant sur `http://localhost:8000/`.

Si vous modifiez un fichier alors que le serveur est en marche il recompilera directement sans que vous ayez besoin de le relancer.


### Demander un token d'accès

Une fois le client créé, à chaque utilisation, il faudra demander un accès. Il faut également pour cela avoir un utilisateur valide.

Pour cela, faites une requête GET à cette route :

```
<hote>/oauth/v2/token?client_id=<public key>&client_secret=<secret>&grant_type=password&redirect_uri=<adresse de redirection>&username=<nom d'utilisateur>&password=<mot de passe>
```

La réponse devrait fournir un access token valable pendant 1h ou jusqu'à déconnexion explicite.


### Requêter l'API

L'access token devra être présent dans le header de chaque requête :

```
Authorization: Bearer <token>
```

Dans le cas d'un test, on pourra utiliser curl :

```
curl --header "Authorization: Bearer <token>" <hote>/api/<route>
```

Ou, de façon plus pratique, l'extension POSTMan de Google Chrome, ou un client REST intégré à un IDE comme celui de PhpStorm.


### Documentation des routes

[La documentation](http://localhost/api/doc) est disponible à l'adresse `http://localhost:8000/api/doc`.

Chaque route devra être documentée en utilisant nelmio/apidoc-bundle. Les tags à indiquer sont les suivants :
- La stabilité
    + stable (#4a7023)
    + unstable (#ff0000)
- Le module concerné, par exemple "kernel" (#0033ff)
- Le niveau de droit nécessaire :
    + super-admin (#da4932)
    + admin (#e0a157)
    + user (#b8c381)
    + guest (#85d893)