# Movizer

## Install

```
docker-compose build
docker-compose up -d

docker exec -it symfonyApp bash
First install : composer install
Update : compose update 

bin/console doctrine:database:create --if-not-exists
bin/console make:migration
bin/console doctrine:schema:update --force

- Load Fixtures:
php bin/console doctrine:fixtures:load
```