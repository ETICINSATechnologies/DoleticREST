DoleticREST
=========

Ce projet est une refactorisation complète du backend de Doletic sous la forme d'une API REST sécurisée et maintenable. A terme, cette API remplacera totalement le backend de Doletic. Un frontend AngularJS est également planifié.

## Comment utiliser l'API

### Intaller les dépendances et générer les paramètres

Les dépendances de l'application sont gérées via composer. Une fois le dépôt forké et cloné, téléchargez les dépendances avec la commande :

```
composer install
```

(Si vous n'avez pas composer sur votre PC, il peut être installé facilement en suivant les instruction de son site officiel.)

Une fois les dépendances installées, composer vous demandera d'entrer les paramètres de l'application. Les paramètres les plus importants sont ceux concernant la base de donnée (utilisateur et mot de passe) qui doivent correspondre à vos installation de mysql. Les valeurs par défauts sont :

```
login : root
mot de passe : test
```

Si les logins correspondent bien, composer va automatiquement générer la base de données.

### Initialiser la base de données

Une fois la base créée, il faut créer son schéma, en utilisant la commande Symfony :

```
php app/console doctrine:schema:update --force
```

Cette commande peut s'abréger en :

```
php app/console d:s:u --force
```

Sans le flag --force, la requête SQL de création de la base ne sera pas exécutée.


### Insérer des données de test (optionnel)

Dans un environnement de développement, il peut être pratique d'insérer de "fausses" données de test. Pour cela, exécutez la commande :

```
php app/console doctrine:fixture:load
```

Ou en abrégé :

```
php app/console do:fi:lo
```

Cette commande crééra notemment un utilisateur ayant pour login et mot de passe "test". Cet utilisateur a tous les droits sur l'application et peut être utilisé pour tester les routes.

Si vous chargez ces données, l'étape suivante (Créer un utilisateur) est inutile.



### Créer un utilisateur (optionnel)

Cette étape est inutile si vous avez exécuté l'étape précédente (dans un environnement de test).

Si vous souhaitez tester l'API sans la relier directement à une application qui gèrera la création des utilisateurs, il peut être utile de créer un utilisateur via une commande. Pour cela, exécutez à la racine du projet :

```
php app/console fos:user:create <nom d'utilisateur> <email> <mot de passe>
```

Cet utilisateur basique pourra être utilisé pour accéder à tout ce qui requiert une authentification complète.

### Créer un client
Pour créer un client de test (une pseudo application qui va requêter l'API), placez-vous à la racine du projet et lancer la commande :

```
php app/console oauth:client:create <nom du client> <adresse de redirection> password
```

Nom du client : Nom de l'application à titre indicatif.

Adresse de redirection :  Adresse vers laquelle rediriger après l'authentification. Pour tester, localhost convient.

Cette commande devrait vous permettre d'obtenir :

+ Une Public key (identifiant client)
+ Un secret

Ces deux paramètres seront utilisés pour utiliser l'API.


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