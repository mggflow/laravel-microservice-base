#!/usr/bin/env bash

start_dir="$(pwd)"

aim_dir="./pulled"

while getopts d: flag; do
    case "${flag}" in
    d*) aim_dir=${OPTARG} ;;
    esac
done

cd "$aim_dir" || exit 1;

cp -f "./env.dev" "./.env"

docker-compose up -d

cd "$start_dir" || exit 1;
