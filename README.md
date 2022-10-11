# tp-php-api

## Partie 1 : Installation & Exploration

Pour ce TP, nous allons partir d'une base de code existant. Vous pouvez le télécharger grâce à git.

```bash
git clone https://github.com/dept-info-iut-dijon/S3-PHP-TPAPI.git
```

Prenez le temps d'explorer le code et comprendre commence celui-ci fonctionne.

Vous aurez à modifier le fichier /src/config/dev.ini avec vos informations de base de donnée (celle de votre grp).

De plus, il vous faudra importer le fichier data/users.sql dans votre BD pour créer la table Users avec quelques données.

Si tout fonctionne, ainsi que le transfert sur votre FTP, vous devriez avoir une réponse JSON à l'adresse

```text
GET http://grp-019.iq.iut21.u-bourgogne.fr/VOTRE-CHEMIN/index.php?service=users
```

Pour visualiser le résultat, le navigateur peut suffir. Cependant, une fois que l'on voudra faire d'autres requêtes que GET, nous seront vite limité !

Pour cela, je vous invite à utiliser un client qui permet de parametrer vos requêtes HTTP :

- en CLI, il y a cURL.
- en extension VSC, il y a Thunder Client par exemple.
- dans PHPStorm, il y a dans tools/http client le moyen d'écrire des requêtes.
- en logiciel/app web, il y a Postman

Pour la suite du TP, je vous recommande Thunder client ou Postman qui vous permettra de créer une collection.


