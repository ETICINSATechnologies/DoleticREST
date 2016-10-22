DoleticREST
=========

Ce projet est une refactorisation complète du backend de Doletic sous la forme d'une API REST sécurisée et maintenable. A terme, cette API remplacera totalement le backend de Doletic. Un frontend AngularJS est également planifié.

## Comment utiliser l'API

### Créer un utilisateur

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