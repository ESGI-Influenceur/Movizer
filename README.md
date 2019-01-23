# Movizer

![Preview](https://raw.githubusercontent.com/ESGI-Influenceur/Movizer/admin/readme/screen.png)


## Install
Install local environnement
```
docker-compose build
docker-compose up -d
```
Install dependency
```
docker exec -it symfonyApp bash 
```
First install : `composer install`

Or Update : `composer update`

Install database schema
```
php bin/console doctrine:database:create --if-not-exists 
php bin/console make:migration
php bin/console doctrine:schema:update --force
```

## Feed the Database from TheMovieDB

```
php bin/console app:feed-db
```

It will call services that call the API and get `Genres`, `Movies` and `TvShows` to feed the DB. Of course it will add only non existent data.

## Heroku cmd

```
heroku run bin/console doctrine:schema:update 
heroku run php bin/console app:feed-db
heroku run bin/console fos:user:create admin test@test.com admin2019 --super-admin
```

## Useful links
- local : [http://localhost](http://localhost)
- local phpmyadmin : [http://localhost:8090](http://localhost:8090)
- local phpmyadmin login : `root`
- local phpmyadmin password : `root`
- production : http://movizer.herokuapp.com
- production admin : http://movizer.herokuapp.com/admin
- production admin login : `admin`
- production admin password : `admin2019`