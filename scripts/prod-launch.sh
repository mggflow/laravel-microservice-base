#!/usr/bin/env bash

start_dir="$(pwd)"

aim_dir="./msvc"

while getopts d: flag; do
    case "${flag}" in
    d*) aim_dir=${OPTARG} ;;
    esac
done

cd "$aim_dir" || exit 1;

cp -a "./env.prod" "./.env"

docker-compose up -d
docker-compose exec -d lv php artisan schedule:work

cd "$start_dir" || exit 1;
