# Movizer

## Install

```
docker-compose build
docker-compose up -d

docker exec -it symfonyApp bash
First install : composer install
Update : compose update 

bin/console doctrine:database:create --if-not-exists
bin/console doctrine:schema:update --force
```