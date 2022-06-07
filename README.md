# Hangover-Backend

Setup 
```
docker-compose up -d
```



Pour accéder à la console du container php (et utiliser des commandes symfony)
```
docker-compose exec php /bin/bash
```

Penser à lancer les migrations et les fixtures !
```
docker-compose exec php /bin/bash
Run composer prepare
```
