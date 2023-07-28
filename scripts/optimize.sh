#!/usr/bin/env bash

start_dir="$(pwd)"

aim_dir="./msvc"

while getopts d: flag; do
    case "${flag}" in
    d*) aim_dir=${OPTARG} ;;
    esac
done

cd "$aim_dir" || exit 1;

docker-compose exec lv composer install --optimize-autoloader --no-dev

docker-compose exec lv php artisan config:cache
docker-compose exec lv php artisan event:cache
docker-compose exec lv php artisan route:cache
docker-compose exec lv php artisan view:cache

cd "$start_dir" || exit 1;
