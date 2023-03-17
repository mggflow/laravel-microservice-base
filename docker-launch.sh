#!/bin/sh

docker-compose up -d
docker-compose exec lv composer install
docker-compose exec -d lv php artisan schedule:work
