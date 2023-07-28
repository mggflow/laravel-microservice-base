#!/usr/bin/env bash

from_dir="./prev"
to_dir="./msvc"

while getopts f:t: flag; do
    case "${flag}" in
    f*) from_dir=${OPTARG} ;;
    t*) to_dir=${OPTARG} ;;
    esac
done

if [ -d "$from_dir/storage/framework/sessions" ]; then
    mkdir -p "$to_dir/storage/framework/sessions"
    cp -a "$from_dir/storage/framework/sessions/." "$to_dir/storage/framework/sessions"
    echo "Sessions data imported"
fi

if [ -d "$from_dir/volumes/pgsql" ]; then
    mkdir -p "$to_dir/volumes/pgsql"
    cp -a "$from_dir/volumes/pgsql/." "$to_dir/volumes/pgsql"
    echo "PostgreSQL data imported"
fi

if [ -d "$from_dir/volumes/mysql" ]; then
    mkdir -p "$to_dir/volumes/mysql"
    cp -a "$from_dir/volumes/mysql/." "$to_dir/volumes/mysql"
    echo "MySQL data imported"
fi

if [ -d "$from_dir/volumes/mariadb" ]; then
    mkdir -p "$to_dir/volumes/mariadb"
    cp -a "$from_dir/volumes/mariadb/." "$to_dir/volumes/mariadb"
    echo "MariaDB data imported"
fi

if [ -d "$from_dir/volumes/redis" ]; then
    mkdir -p "$to_dir/volumes/redis"
    cp -a "$from_dir/volumes/redis/." "$to_dir/volumes/redis"
    echo "Redis data imported"
fi

if [ -d "$from_dir/volumes/selenium/chrome-data" ]; then
    mkdir -p "$to_dir/volumes/selenium/chrome-data"
    cp -a "$from_dir/volumes/selenium/chrome-data/." "$to_dir/volumes/selenium/chrome-data"
    echo "Selenium Chrome data imported"
fi


if [ -f "$from_dir/env.dev" ]; then
    cp -a "$from_dir/env.dev" "$to_dir/env.dev"
fi

if [ -f "$from_dir/env.prod" ]; then
    cp -a "$from_dir/env.prod" "$to_dir/env.prod"
fi

