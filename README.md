# Movizer

## Install

```
docker-compose build
docker-compose up -d

docker exec -it symfonyApp bash
First install : composer install
Update : compose update 

php bin/console doctrine:database:create --if-not-exists
php bin/console make:migration
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```