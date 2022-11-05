#!/bin/sh

docker-compose up -d
docker-compose exec lv composer install
docker-compose exec lv php artisan schedule:work
