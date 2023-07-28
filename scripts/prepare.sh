#!/usr/bin/env bash

start_dir=$(pwd)

user_id=$(id -u)
group_id=$(id -g)
aim_dir="./msvc"

while getopts u:g:d: flag; do
    case "${flag}" in
    u*) user_id=${OPTARG} ;;
    g*) group_id=${OPTARG} ;;
    d*) aim_dir=${OPTARG} ;;
    esac
done

cd "$aim_dir" || exit 1;

mkdir -p "./volumes/pgsql"
mkdir -p "./volumes/mysql"
mkdir -p "./volumes/mariadb"
mkdir -p "./volumes/redis"
mkdir -p "./volumes/selenium/chrome-data"

touch "./env.dev"
touch "./env.prod"

chown -R "$user_id":"$group_id" "$aim_dir"
chmod -R ug+rwx "$aim_dir"

docker run --rm \
    -u "$user_id:$group_id" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

cd "$start_dir" || exit 1;
