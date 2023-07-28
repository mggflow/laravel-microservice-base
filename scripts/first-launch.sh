#!/usr/bin/env bash

start_dir="$(pwd)"

aim_dir="./pulled"

while getopts d: flag; do
    case "${flag}" in
    d*) aim_dir=${OPTARG} ;;
    esac
done

cd "$aim_dir" || exit 1

if [ ! -s "./env.dev" ]; then
    cp -a "./.env.example" "./env.dev"
fi

cp -f "./env.dev" "./.env"

docker-compose build --no-cache
docker-compose up -d
docker-compose exec lv composer install

APP_KEY=$(grep --color=never -Po "^APP_KEY=\K.*" ./.env || true)
[ ${#APP_KEY} -le 3 ] && docker-compose exec lv php artisan key:generate --ansi

docker-compose exec lv php artisan migrate
docker-compose down

APP_KEY=$(grep --color=never -Po "^APP_KEY=\K.*" ./.env || true)
sed -i 's,^APP_KEY\=.*,APP_KEY='"$APP_KEY"',' ./env.dev
sed -i 's,^APP_KEY\=.*,APP_KEY='"$APP_KEY"',' ./env.prod


cd "$start_dir" || exit 1
