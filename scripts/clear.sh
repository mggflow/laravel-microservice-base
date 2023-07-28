#!/usr/bin/env bash

start_dir="$(pwd)"

aim_dir="./msvc"

while getopts d: flag; do
    case "${flag}" in
    d*) aim_dir=${OPTARG} ;;
    esac
done

cd "$aim_dir" || exit 1;

docker-compose exec lv composer install

docker-compose exec lv php artisan config:clear
docker-compose exec lv php artisan event:clear
docker-compose exec lv php artisan route:clear
docker-compose exec lv php artisan view:clear

cd "$start_dir" || exit 1;
