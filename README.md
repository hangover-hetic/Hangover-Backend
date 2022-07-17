# Hangover Api
Api de l'application Hangover.

Stack :
 - Symfony + Api Platform
 - Mercure pour le temps réel
 - Postgre pour la base de donnée

## Démonstration
Une version de démonstration de l'api est disponible ici : https://hangover.timotheedurand.fr/api

Pour la documentation voir [ici](https://hangover.timotheedurand.fr/docs).

Pour adminer voir [ici](https://hangover.timotheedurand.fr/admin?pgsql=database&username=lccuser&db=app) (mot de passe : lccpwd).

## Setup 
```
docker compose up -d
```

Pour accéder à la console du container php (et utiliser des commandes symfony)
```
docker compose exec php sh
```

Pour le premier lancement :
```
docker compose exec php sh
composer install
composer prepare
```

`composer prepare` : drop la bdd, la recréer, lance les migrations, les fixtures et supprime les medias

## Documentation
La documentation d'Api Platform est disponible à l'adresse http://localhost:8080/docs.

## Adminer
Adminer est disponible à l'adresse http://localhost:8081