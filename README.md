# Movizer

![Preview](https://raw.githubusercontent.com/CNadjim/spring-boot-oauth2/master/assets/screen.png)


## Install

```
docker-compose build
docker-compose up -d

docker exec -it symfonyApp bash // connexion au container symfony
First install : composer install // installation des dépendances 
Or Update : composer update  // ou simple mise à jour

php bin/console doctrine:database:create --if-not-exists 
php bin/console make:migration
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

## Feed the Database from TheMovieDB

```
php bin/console app:feed-db
```

It will call services that call the API and get `Genres`, `Movies` and `TvShows` to feed the DB. Of course it will add only non existent data.