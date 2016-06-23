<h1>Tournament Manager API</h1>
<hr/>
Tournament Manager API

Cette API permet la gestion de tournois de jeux en ligne de manière simple et efficace.

<h2>Getting Started</h2>

Les instructions vont vous permettre d'installer le projet en local sur votre machine.

<h3>Prerequisities</h3>

Pour installer le projet, vous devez installer : 

<li>Composer </li>

<h3>Installing</h3>

Ouvrez le terminal de votre ordinateur, allez dans le dossier d'installation du projet et cloner le dépot.

Allez dans le dépot et faites les commandes suivantes pour créer une clé SSL

```
cd NOM_DU_DOSSIER
mkdir -p var/jwt
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem

```
Créez une base de données pour votre projet.
Installez les dépendances du projet.

`composer update`

Complétez les informations lors de l'installation (connexion avec votre base de données notamment)

Générez les tables avec la commande suivante
```
php bin/console doctrine:schema:update --force

```
<h3>Générez la documentation (optionnel)</h3>

Premièrement, vous devez installer [PHPDocumentor](https://phpdoc.org/docs/latest/getting-started/installing.html). 

Puis, allez dans votre projet et faites la commande: 

`phpdoc -d ./src -t ./docs`

Avec votre navigateur, allez sur [http://127.0.0.1/docs](http://127.0.0.1/docs) pour lire la doc.
Vous pouvez voir les différentes routes accessibles par l'API via l'adresse: 
http://localhost/NOMDUPROJET/web/app_dev.php/api/doc
Les routes se mettent à jour automatiquement.

<h2>Authors</h2>

<li>Mavilaz Rémi [Github](https://github.com/KizeRemi)