#!/usr/bin/env bash

docker-compose down
docker-compose build && docker-compose up -d
docker-compose exec php composer install
docker-compose exec php ./vendor/bin/phpunit ./tests/